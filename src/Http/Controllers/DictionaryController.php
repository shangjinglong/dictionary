<?php
namespace Shangjinglong\Dictionary\Http\Controllers;
use App\Http\Controllers\Controller;
use Shangjinglong\Dictionary\Dictionary;
class DictionaryController extends Controller
{
    public  static function generate(){
        $dictionary = new Dictionary();
        $html = $dictionary->generate();
        return $html;
    }
}