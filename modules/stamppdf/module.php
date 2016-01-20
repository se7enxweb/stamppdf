 
<?php


$Module = array(
    'name'              => "Mugo Stamp PDF"
    , "variable_params" => true
);

$ViewList = array();

$ViewList['test'] = array( 'functions' => array( 'stamppdf' )
                           , 'script' => 'test.php' );
$ViewList['download'] = array(
                                'functions' => array( 'stamppdf' )
                                , 'script' => 'download.php'
                                , 'params' => array( 'ObjectID')
                            );
$FunctionList = array();
$FunctionList[ 'stamppdf' ] = array();
 
?>
