<?php

    namespace application\components\db;

    use \Yii;
    use \CMap as Map;
    use \CException as Exception;
    use \CActiveRecord as YiiActiveRecord;
    use \application\components\helpers\Text;

    // Dependancy: Zend Framework 1.12.6
    use \Zend_Search_Lucene_Exception               as LuceneException;
    use \Zend_Search_Lucene_Interface               as LuceneInterface;
    use \Zend_Search_Lucene                         as Indexer;
    use \Zend_Search_Lucene_Document                as IndexDocument;
    use \Zend_Search_Lucene_Field                   as DocumentField;
    use \Zend_Search_Lucene_Search_Query_Boolean    as QueryContainer;
    use \Zend_Search_Lucene_Search_Query_MultiTerm  as QueryTermsContainer;
    use \Zend_Search_Lucene_Search_QueryParser      as QueryParser;
    use \Zend_Search_Lucene_Index_Term              as QueryTerm;

    abstract class ActiveRecord extends YiiActiveRecord
    {

        const FIELD_MODEL_CLASS = '__modelClass';
        const FIELD_MODEL_PK    = '__modelPk';
        const PK_SEPARATOR      = "\0";

        /**
         * @static
         * @access public
         * @var boolean $enableIndex
         */
        public static $enableIndex = false;

        /**
         * @static
         * @access public
         * @var boolean $enableIndex
         */
        public static $indexSaveDir = 'application.data.arindex';

        /**
         * @static
         * @access public
         * @var integer $gcProbability
         */
        public static $gcProbability = 1;

        /**
         * @static
         * @access public
         * @var integer $gcDivisor
         */
        public static $gcDivisor = 100;

        /**
         * @static
         * @access public
         * @var boolean $useIndexQueryParser
         */
        public static $useIndexQueryParser = true;

        /**
         * @static
         * @access private
         * @var Zend_Search_Lucene $index
         */
        private static $index;

        /**
         * Create Empty Index
         *
         * This method will create an index in the configured save directory, and empty any index that was there
         * previously.
         *
         * @static
         * @access public
         * @return boolean
         */
        public static function createEmptyIndex()
        {
            if(!self::$enableIndex) {
                throw new Exception(Yii::t('app', 'Will not create empty index, as search indexing is not enabled.'));
            }
            try {
                Indexer::create(Yii::getPathOfAlias(self::$indexSaveDir));
                return true;
            }
            catch(LuceneException $e) {
                return false;
            }
        }

        /**
         * Initialise Index
         *
         * @access private
         * @return Zend_Search_Lucene
         */
        private static function initialiseIndexer()
        {
            if(!self::$enableIndex) {
                return;
            }
            if(self::$index instanceof LuceneInterface) {
                return self::$index;
            }
            try {
                $index = Indexer::open(Yii::getPathOfAlias(self::$indexSaveDir));
                return $index;
            }
            catch(LuceneException $e) {
                throw new Exception(
                    Yii::t(
                        'app',
                        'Search indexing has been enabled for ActiveRecord but the index could not be accessed. Please create the index or check filesystem permissions.'
                    )
                );
            }
        }

        /**
         * Index Model
         *
         * @access protected
         * @param string $index
         * @param integer $modelId
         * @param array $fields
         * @return boolea
         */
        final protected function indexDocument(array $fields = array())
        {
            // First things first, we do not want to index any model that has not been persisted to disk. Secondly, we
            // cannot create a searchable document for this model if we cannot initialise the Indexer.
            if($this->isNewRecord || !($index = self::initialiseIndexer()) instanceof LuceneInterface) {
                return false;
            }
            // Next, we determine which Active Record model is calling this function (as many models extend from this
            // base class). Then determine a unique string from the primary key (which may be composite).
            $modelClass = get_called_class();
            $primaryKeyString = implode(self::PK_SEPARATOR, (array) $this->getPrimaryKey());
            // Wrap everything to do with Zend's Lucene in a try block in case something goes wrong.
            try {
                // Now that we know we can index this model, we want to delete any previous index of it (you can only
                // add or delete "documents" into the index, not update them).
                $query = new QueryTermsContainer;
                $query->addTerm(new QueryTerm($modelClass,          self::FIELD_MODEL_CLASS),   true);
                $query->addTerm(new QueryTerm($primaryKeyString,    self::FIELD_MODEL_PK),      true);
                foreach($index->find($query) as $hit) {
                    $index->delete($hit->id);
                }
                // Create a new document to insert into the search index.
                $document = new IndexDocument;
                // Create the necessary fields (which model it is, and the record's primary key), and delete them from
                // the fields to add to the document so that they don't get overwritten (along with some reserved field
                // names).
                $document->addField(DocumentField::keyword(self::FIELD_MODEL_CLASS, $modelClass));
                $document->addField(DocumentField::keyword(self::FIELD_MODEL_PK, $primaryKeyString));
                unset(
                    $fields[self::FIELD_MODEL_CLASS],
                    $fields[self::FIELD_MODEL_PK],
                    $fields['score'],
                    $fields['id']
                );
                // Now we want to add these fields to the document (specifying that while they should be added to the index,
                // there is no point storing it's value because they are already stored in the database).
                foreach($fields as $field => $value) {
                    $document->addField(DocumentField::unStored($field, Text::anglicise($value)));
                }
                // Woohoo! We've created our searchable document, now add it to the index and commit all our changes!
                $index->addDocument($document);
                $index->commit();
            }
            catch(LuceneException $e) {
                return false;
            }
            // We should run garbage collection (index optimisation).
            $this->indexGarbageCollection($index);
            // Everything is completed. Return a success value.
            return true;
        }

        /**
         * Garbage Collection
         *
         * Optimise the given index a certain percentage of the time. Calculate this by running every $gcProbability out
         * of $gcDivisor times. For example: a probability of 1 and a divisor of 100 would run 1% of time, and a
         * probability of 3 and a divisor of 4 would run 75% of the time.
         *
         * @access private
         * @param Zend_Search_Lucene $index
         * @return void
         */
        private function indexGarbageCollection(LuceneInterface $index)
        {
            if(self::$gcProbability >= (mt_rand(0, 1) * self::$gcDivisor)) {
                try {
                    $index->optimize();
                }
                // If something goes wrong with the optimisation don't bother doing anything.
                catch(LuceneException $e) {}
            }
        }

        /**
         * Query Search Index
         *
         * @final
         * @access public
         * @param string $query
         * @param integer $page
         * @param integer $pageSize
         * @return ActiveRecord[]
         */
        final public function queryIndex($queryString, $page = 1, $pageSize = 25)
        {
            // If the index has not been enabled, return null.
            if(!($index = self::initialiseIndexer()) instanceof LuceneInterface) {
                return;
            }
            // If the query provided is not a string or empty, return an empty set of results.
            if(!is_string($queryString) || empty($queryString = trim(Text::anglicise($queryString)))) {
                return array();
            }

            // Define the main search query object we will use against the index, and specify how many results we want back.
            $query = new QueryContainer;
            Indexer::setResultSetLimit($pageSize);

            // Do we want to use Zend's query parser or not?
            if(self::$useIndexQueryParser) {
                $userQuery = QueryParser::parse($queryString);
            }
            else {
                $queryItems = preg_split('/\\s+/', $queryString, -1, PREG_SPLIT_NO_EMPTY);
                $userQuery = new QueryTermsContainer;
                foreach($queryItems as $queryItem) {
                    $userQuery->addTerm(new QueryTerm($queryItem));
                }
            }

            // Add the user query, regardless of how it was generated, to the main search query object.
            $query->addSubquery($userQuery, true);

            // Determine which Active Record model is calling this function (as many models extend from this base class).
            $modelClass = get_called_class();

            $modelQuery = new QueryTermsContainer;
            $modelQuery->addTerm(new QueryTerm($modelClass, self::FIELD_MODEL_CLASS), true);
            $query->addSubquery($modelQuery, true);

            // Use the main query object to fetch the results from the index.
            $hits = $index->find($query);

            $results = array();
            $primaryKeyColumn = $this->getMetaData()->tableSchema->primaryKey;
            foreach($hits as $hit) {
                if(is_string($primaryKeyColumn)) {
                    $result = $this->findByPk($hit->{self::FIELD_MODEL_PK});
                }
                elseif(is_array($primaryKeyColumn)) {
                    $result = $this->findByPk(array_combine(
                        $primaryKeyColumn,
                        explode(self::PK_SEPARATOR, $hit->{self::FIELD_MODEL_PK})
                    ));
                }
                if($result !== null) {
                    $results[] = $result;
                }
            }

            // Return the results as an array of models.
            return $results;
        }

        /**
         * Abstract: Index
         *
         * Override this method with a customised call to indexDocument() if you want this model to be indexed.
         *
         * @access public
         * @return void
         */
        public function index()
        {
        }

        /**
         * Event: After Save
         *
         * @access public
         * @return boolean
         */
        public function afterSave()
        {
            $this->index();
            return parent::afterSave();
        }

    }
