<?php

namespace PhantomInstaller;

class PhantomBinary
{
    const BIN = 'C:\Users\jliu1\Documents\Projects\github_lapse\lapse\bin\phantomjs.exe';
    const DIR = 'C:\Users\jliu1\Documents\Projects\github_lapse\lapse\bin';

    public static function getBin() {
        return self::BIN;
    }

    public static function getDir() {
        return self::DIR;
    }
}
