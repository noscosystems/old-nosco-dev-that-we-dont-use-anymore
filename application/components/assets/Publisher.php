<?php

    namespace application\components\assets;

    use \Yii;
    use \CException as Exception;
    use \CAssetManager as YiiAssetManager;

    class Publisher extends YiiAssetManager
    {

        /**
         * Embed Asset
         *
         * @access public
         * @param string $file
         * @param string $mimeType
         * @param string $charset
         * @return string
         */
        public function embed($file, $mimeType, $charset = 'utf-8')
        {
            if(!file_exists($file)) {
                throw new Excpetion(Yii::t('app', 'Cannot embed asset URI. File does not exist.'));
            }
            return 'data:' . $mimeType . ';charset=' . $charset . ';base64,' . base64_encode(file_get_contents($file));
        }

    }
