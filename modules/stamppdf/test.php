<?php

$module = $Params['Module'];

$http = eZHTTPTool::instance();
$tpl = eZTemplate::factory();
$errors = array();

$tpl->resetVariables();

if ($http->hasPostVariable('pdf_string'))
{

    if ($http->postVariable('pdf_string') == '')
    {
        $errors[] = "Empty string";
    }
}

if (count($errors) == 0 and $http->hasPostVariable('pdf_string'))
{
    $pdf = 'extension/stamppdf/design/standard/images/MugoCollaborationWorkflowProductSheet.pdf';

    $label = htmlspecialchars($http->postVariable('pdf_string'), ENT_QUOTES);
    $filename = time() . '_' . rand(1,1000) . '.pdf';
    $stamp = eZSys::varDirectory() . DIRECTORY_SEPARATOR . 'cache/stamp_' . $filename;

    exec("convert -size 2550x3500 -bordercolor white -border 20x20 -transparent white -pointsize 64  -fill red -font Helvetica-Bold label:'{$label}'  {$stamp}" );

    header("Content-Type: application/pdf");
    header("Cache-Control: no-cache");
    header("Accept-Ranges: none");
    header("Content-Disposition: attachment; filename=\"MugoCollaborationWorkflowProductSheet.pdf\"");

    ob_start();
    passthru( "pdftk {$pdf} stamp {$stamp} output -");
    $output = ob_get_contents();
    ob_end_clean();
    unlink($stamp);
    print($output);

    eZExecution::cleanExit();

}


$tpl->setVariable('errors', $errors);

$Result = array();
$Result['path'] = array(array('url' => false,
        'text' => 'Stamp PDF'),
    array('url' => false,
        'text' => 'Form'));
$Result['content'] = $tpl->fetch("design:stamppdf/form.tpl");
