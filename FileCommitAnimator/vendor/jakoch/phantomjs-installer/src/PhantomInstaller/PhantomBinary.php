<?php

namespace PhantomInstaller;

class PhantomBinary
{
    const BIN = 'C:\Users\jliu1\Documents\Projects\timelapse\FileCommitAnimator\bin\phantomjs.exe';
    const DIR = 'C:\Users\jliu1\Documents\Projects\timelapse\FileCommitAnimator\bin';

    public static function getBin() {
        return self::BIN;
    }

    public static function getDir() {
        return self::DIR;
    }
}
