<?php

class  ImageOptimisation{

    public $errors = [] ;

    public function err($str){
        $this->errors[] = $str ;
        return false ;
    }

    public function __construct($file)
    {
        $this->file = realpath($file) ;
    }

    public function optimize()
    {
        if (!is_file($this->file)) {
            return $this->err('file not found '. $this->file) ;
        }

        $info = @getimagesize($this->file);
        if (!is_array($info)) {
            return $this->err('Unable to get file type') ;
        }

        $TYPE = $info[2] ;

        if ($TYPE == IMAGETYPE_GIF) {
            return $this->exec('gif');
        } elseif ($TYPE == IMAGETYPE_JPEG) {
            return $this->exec('jpg');
        } elseif ($TYPE == IMAGETYPE_PNG){
            return $this->exec('png');
        }else {
            return $this->err('File type not supported '. $TYPE . ' ' . $info['mime']) ;
        }
    }

    public function exec($type){

        $bin_path = realpath( __DIR__ .'/bin').DIRECTORY_SEPARATOR ;

        $cmds = ['jpg' => 'jpegtran.exe -optimize  -progressive -copy none @file @file' ,
                'png'=> 'pngquant.exe --speed 1 --ext=.png --force @file' ,
                'gif' => 'gifsicle.exe -b -O2 @file'] ;

        $cmd = str_replace('@file',escapeshellarg($this->file),$cmds[$type]) ;
        exec( '@'.$bin_path . $cmd, $aOutput, $iResult) ;
        if ($iResult == 0) {
            return true;
        }
        return $this->err('Execution faild '. '@'.$bin_path . $cmd . ' ' . serialize($iResult).' ' . serialize($aOutput)) ;
    }

}