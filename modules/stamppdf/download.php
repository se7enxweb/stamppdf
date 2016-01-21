<?php

$Module = $Params['Module'];
$ObjectID = $Params['ObjectID'];

$fileObj = eZContentObject::fetch($ObjectID);

if ( !is_object( $fileObj ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$fileObjDataMap = $fileObj->attribute('data_map');

if ( !isset( $fileObjDataMap['file'] ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
}

$fileAttr = $fileObjDataMap['file']->attribute('content');
$pdf = $fileAttr->attribute('filepath');

$currentUser = eZUser::currentUser();
$currentUserObj = $currentUser->attribute('contentobject');
$label = "Downloaded by " . htmlspecialchars($currentUserObj->attribute('name'), ENT_QUOTES) . ' on ' . date('n/j/Y');
$filename = $currentUser->attribute('contentobject_id') . '_' . time() . '.pdf';
$stamp = eZSys::varDirectory() . DIRECTORY_SEPARATOR . 'cache/stamp_' . $filename;

exec("convert -size 2550x3500 -bordercolor white -border 20x20 -transparent white -pointsize 64  -fill red -font Helvetica-Bold label:'{$label}'  {$stamp}" );



header("Content-Type: application/pdf");
header("Cache-Control: no-cache");
header("Accept-Ranges: none");
header("Content-Disposition: attachment; filename=\"{$fileAttr->attribute('original_filename')}\"");

ob_start();
passthru( "pdftk {$pdf} stamp {$stamp} output -");
unlink($stamp);
$output = ob_get_contents();
ob_end_clean();

print($output);

eZExecution::cleanExit();


?>
