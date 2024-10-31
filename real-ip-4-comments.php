<?php
/**
* Plugin Name: Real IP 4 Comments
* Plugin URI: http://romantelychko.com/downloads/wordpress/plugins/real-ip-4-comments.latest.zip
* Description: Correct comment's IP address with HTTP_X_REAL_IP and/or HTTP_X_FORWARDED_FOR HTTP header and/or Opera Trusted Proxy.
* Version: 0.2.1
* Author: Roman Telychko
* Author URI: http://romantelychko.com
*/

///////////////////////////////////////////////////////////////////////////////

function RealIP4Comments()
{
    if( isset($_SERVER['HTTP_X_REAL_IP']) && !empty($_SERVER['HTTP_X_REAL_IP']) )
    {
        if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) )
        {
            if( $_SERVER['HTTP_X_FORWARDED_FOR']!=$_SERVER['HTTP_X_REAL_IP'] )
            {
                $realip_long = ip2long( $_SERVER['HTTP_X_REAL_IP'] );
                
                $realip4comments_opera_trusted_proxy = array(

                    # opera trusted proxy list: http://wipmania.com/static/worldip.opera.conf
                    # for convert, uses: http://share-foo.com/SubnetCalc.php

                    '59.151.106.227' => array(
                        'from'  => 999779043,
                        'to'    => 999779043,
                        ),
                    '59.151.106.228/30' => array(
                        'from'  => 999779044,
                        'to'    => 999779046,
                        ),
                    '59.151.106.232/29' => array(
                        'from'  => 999779048,
                        'to'    => 999779054,
                        ),
                    '59.151.106.240/29' => array(
                        'from'  => 999779057,
                        'to'    => 999779062,
                        ),
                    '59.151.106.248/30' => array(
                        'from'  => 999779065,
                        'to'    => 999779066,
                        ),
                    '59.151.106.252' => array(
                        'from'  => 999779068,
                        'to'    => 999779068,
                        ),
                    '64.255.164.0/24' => array(
                        'from'  => 1090495489,
                        'to'    => 1090495742,
                        ),
                    '64.255.180.0/24' => array(
                        'from'  => 1090499585,
                        'to'    => 1090499838,
                        ),
                    '80.232.117.0/24' => array(
                        'from'  => 1357411585,
                        'to'    => 1357411838,
                        ),
                    '80.239.242.0/23' => array(
                        'from'  => 1357902337,
                        'to'    => 1357902846,
                        ),
                    '82.145.208.0/22' => array(
                        'from'  => 1385287681,
                        'to'    => 1385288702,
                        ),
                    '82.145.212.0/22' => array(
                        'from'  => 1385288705,
                        'to'    => 1385289726,
                        ),
                    '91.203.96.0/25' => array(
                        'from'  => 1540055041,
                        'to'    => 1540055166,
                        ),
                    '91.203.98.0/24' => array(
                        'from'  => 1540055553,
                        'to'    => 1540055806,
                        ),
                    '195.189.142.0/23' => array(
                        'from'  => -1010987519,
                        'to'    => -1010987010,
                        ),
                    '141.0.8.0/21' => array(
                        'from'  => -1929377791,
                        'to'    => -1929375746,
                        ),       
                );

                foreach( $realip4comments_opera_trusted_proxy as $opera_ip )
                {
                    if( $realip_long>=$opera_ip['from'] && $realip_long<=$opera_ip['to'] )
                    {
                        $temp = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
                        
                        if( isset($temp['0']) && filter_var( trim($temp['0']), FILTER_VALIDATE_IP ) )
                        {
                            return trim($temp['0']);
                        }

                        break;
                    }
                }
            }
        }

        return $_SERVER['HTTP_X_REAL_IP'];
    }
    else
    {
        if( isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) )
        {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    
    return '127.0.0.1';
}

///////////////////////////////////////////////////////////////////////////////

$_SERVER['REMOTE_ADDR'] = RealIP4Comments();

///////////////////////////////////////////////////////////////////////////////
