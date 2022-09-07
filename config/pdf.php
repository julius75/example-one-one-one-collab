<?php
/**
 * Created by PhpStorm.
 * User: lexxyungcarter
 * Date: 20/09/2019
 * Time: 10:49
 */

/**
 * mPDF Wrapper by mccarlosen
 *
 * To override this configuration on a per-file basis use the fourth parameter of the initializing call like this:
 *
    MPDF::loadView('pdf', $data, [], [
        'title' => 'Another Title',
        'margin_top' => 0,
        'mode' => 'utf-8,
        'orientation' => 'L',
        [190, 236], // page will be 190mm wide x 236mm height
    ])->save($pdfFilePath);
 *
 * @source https://github.com/mccarlosen/laravel-mpdf
 */
return [
    'mode'                 => '',
    'format'               => 'A4',
    'default_font_size'    => '12',
    'default_font'         => 'sans-serif',
    'margin_left'          => 10,
    'margin_right'         => 10,
    'margin_top'           => 10,
    'margin_bottom'        => 10,
    'margin_header'        => 0,
    'margin_footer'        => 0,
    'orientation'          => 'P',
    'title'                => 'Collabmed System PDF',
    'author'               => '',
    'watermark'            => '',
    'show_watermark'       => false,
    'watermark_font'       => 'sans-serif',
    'display_mode'         => 'fullpage',
    'watermark_text_alpha' => 0.1,
    'custom_font_dir'      => '',
    'custom_font_data' 	   => [],
    'auto_language_detection'  => false,
    'temp_dir'               => '',
];