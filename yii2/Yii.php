<?php
$dir = __DIR__ . '/../../../yiisoft/yii2';
require $dir.'/BaseYii.php';

class Yii extends \yii\BaseYii
{
    public static $service;

    /**
     * rewriteMap , like:
     * [
     *    '\flexcrm\models\mongodb\Category'  => '\admin\models\mongodb\Category'
     * ]
     */
    public static $rewriteMap;

    /**
     * @param $absoluteClassName | String , like: '\flexcrm\app\front\modules\Cms\block\home\Index'
     * @param array $arguments | Array ,数组，里面的每一个子项就是用于实例化的一个参数，多少个子项，就代表有多个参数，用于对象的实例化
     * 通过$rewriteMap，查找是否存在重写，如果存在，则得到重写的className
     * @return array | 然后返回 类名 和 对象
     */
    public static function mapGet($absoluteClassName, $arguments = []) {
        $absoluteClassName = self::mapGetName($absoluteClassName);
        if (!empty($arguments) && is_array($arguments)) {
            $class = new ReflectionClass($absoluteClassName);
            $absoluteOb = $class->newInstanceArgs($arguments);

            /**
             * 下面的 ...，是php的语法糖(只能php5.6以上，放弃)，也就是把$paramArray数组里面的各个子项参数，
             *  作为对象生成的参数，详细可以参看：https://segmentfault.com/q/1010000006789348
             */
            //$absoluteOb = new $absoluteClassName(...$arguments);
        } else {
            $absoluteOb = new $absoluteClassName;
        }

        return [$absoluteClassName, $absoluteOb];
    }

    /**
     * @param $absoluteClassName | String , like: '\flexcrm\app\front\modules\Cms\block\home\Index'
     * @return mixed
     * 通过$rewriteMap，查找是否存在重写，如果存在，则返回重写的className
     */
    public static function mapGetName($absoluteClassName) {
        if (isset(self::$rewriteMap[$absoluteClassName]) && self::$rewriteMap[$absoluteClassName]) {
            $absoluteClassName = self::$rewriteMap[$absoluteClassName];
        }
        return $absoluteClassName;
    }

    /**
     * @param $className | String , block等className，前面没有`\`, like: 'flexcrm\app\front\modules\Catalog\block\product\CustomOption'
     * @return bool|string
     * 通过$rewriteMap，查找是否存在重写，如果存在，则返回重写的className
     */
    public static function mapGetClassName($className) {
        $absoluteClassName = '\\'.$className;
        if (isset(self::$rewriteMap[$absoluteClassName]) && self::$rewriteMap[$absoluteClassName]) {
            $absoluteClassName = self::$rewriteMap[$absoluteClassName];
            return substr($absoluteClassName, 1);
        }
        return $className;
    }
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = require $dir.'/classes.php';
Yii::$container = new \yii\di\Container();