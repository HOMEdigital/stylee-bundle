<?php


namespace Home\StyleeBundle\Resources\contao\modules;


class CopyFilesModule extends \Contao\BackendModule
{
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_stylee';

    /**
     * Generate the module
     *
     * @throws \Exception
     */
    protected function compile()
    {
        \System::loadLanguageFile('tl_maintenance');
        $this->Template->href = $this->getReferer(true);
        $this->Template->title = \StringUtil::specialchars($GLOBALS['TL_LANG']['MSC']['backBTTitle']);
        $this->Template->button = $GLOBALS['TL_LANG']['MSC']['backBT'];

        $this->Template->notFound = $this->copyFiles();
    }

    protected function copyFiles()
    {
        $notFound = array();
        $filesToCopy = array(
            #-- isotope-layout
            array(
                'source' => '/../../../node_modules/isotope-layout/dist/isotope.pkgd.min.js',
                'target' => '/../../public/isotope.pkgd.min.js'
            ),
            #-- isotope-packery
            array(
                'source' => '/../../../node_modules/isotope-packery/packery-mode.pkgd.min.js',
                'target' => '/../../public/packery-mode.pkgd.min.js'
            ),
            #-- imagesloaded
            array(
                'source' => '/../../../node_modules/imagesloaded/imagesloaded.pkgd.min.js',
                'target' => '/../../public/imagesloaded.pkgd.min.js'
            ),
        );

        #-- check that public folder exists
        if(!file_exists(__DIR__ . '/../../public/')){
            mkdir(__DIR__ . '/../../public/');
        }

        #-- copy files to public folder
        foreach ($filesToCopy as $file){
            if(file_exists(__DIR__ . $file['source'])){
                copy(__DIR__ . $file['source'], __DIR__ . $file['target']);
            }else{
                $notFound[] = $file['source'];
            }
        }

        return $notFound;
    }
}
