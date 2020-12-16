<?php

use XHGui\Saver\SaverInterface;
use XHGui\ServiceContainer;

if (!defined('XHGUI_ROOT_DIR')) {
    require dirname(__DIR__) . '/src/bootstrap.php';
}

$options = getopt('f:');

if (!isset($options['f'])) {
    throw new InvalidArgumentException('You should define a file to be loaded');
}
$file = $options['f'];

if (!is_readable($file)) {
    throw new InvalidArgumentException($file . ' isn\'t readable');
}

$container = ServiceContainer::instance();
/** @var SaverInterface $saver */
$saver = $container['saver'];

$fileData = file_get_contents($file);

$data = json_decode($fileData, true);
if (isset($data[0])) {
    try {
        $saver->save($data[0]);
    } catch (Throwable $e) {
        error_log($e);
    }

}

