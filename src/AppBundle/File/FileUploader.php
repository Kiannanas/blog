<?php

namespace AppBundle\File;

use Symfony\Component\HttpFoundation\File\File;

class FileUploader
{
	//chemin sur la machine
	private $filePath;

	// chemin du fichier dans le projet
	private $fileWebPath;

	public function __construct($filePath, $fileWebPath){
		$this->filePath = $filePath;
		$this->fileWebPath = $fileWebPath;
	}

	public function upload($object)
	{
		if (!$file = $object->getHeaderImage()) {
            return;
        }
        //$file = new File($object->getHeaderImage());
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->filePath, $filename);
        $object->setHeaderImage($this->fileWebPath.$filename);

        return $object;
	}
}