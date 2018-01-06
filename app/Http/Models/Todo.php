<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Todo extend Model{
    
    // ソフトデリート機能をクラスに追加
    use SoftDeletingTrait;

    const STATUS_IMCOMPLETE = 1;
    const STATUS_COMPLETE = 2;

    
}
