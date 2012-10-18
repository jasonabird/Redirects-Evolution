/*####
#
#	Name: Redirect
#	Author: Three Eyed Bird Design
#	Version: 0.0.4
#	Date: 8/20/10
#	Based on original plugin NG!Redirect version 0.0.2 by
#	Stefan Bruggmann - http://www.ng-projects.ch
#
####
#
#	Version Notes
#	0.0.4
#	Added the $base and $siteurl variables for handling different site bases
#	Added $siteurl for redirect to handle redircting category
#
###
#
# Usage:
# Enter your old Site-Names and the new static ones or dynamic id's to the following array like..
#
# Example:
# $sites = array(
# 	$base.'The-Old-URL' => 6,
# 	$base.'Another-Old-URL' => 'A-New-Hard-Link',
#	$base.'folder/' => 6
# );
#
####
*/

//Set base url
$base = MODX_BASE_URL;
$siteurl = MODX_SITE_URL;

$sites = array(
	$base.'oldpage.html' => 1,
	$base.'contactustoday.html' => 6,
	$base.'folder/' => 7,
);
$e = &$modx->event;
if($e->name == "OnPageNotFound")
{
	//Get Current URL
	$current = $_SERVER["REQUEST_URI"];
	foreach( $sites as $k => $v ){
			if( $k==$current ){
				if( is_numeric($v) ){
					$obj = $modx->getDocumentObject('id', $v);
					$url = $siteurl.$obj['alias'].$modx->config['friendly_url_suffix'];
				}else{
					$url = $v;
				}
				$this->sendRedirect($url, 0, 'REDIRECT_HEADER', 'HTTP/1.1 301 Moved Permanently');
				exit;
			}
	}
}