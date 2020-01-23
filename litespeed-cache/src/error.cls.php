<?php
/**
 * The error class.
 *
 * @since      	3.0
 * @package    	LiteSpeed
 * @subpackage 	LiteSpeed/src
 * @author     	LiteSpeed Technologies <info@litespeedtech.com>
 */
namespace LiteSpeed;

defined( 'WPINC' ) || exit;

class Error
{
	private static $CODE_SET = array(
		'HTA_LOGIN_COOKIE_INVALID' => 4300, // .htaccess did not find.
		'HTA_DNF'		 => 4500, // .htaccess did not find.
		'HTA_BK'		 => 9010, // backup
		'HTA_R'			 => 9041, // read htaccess
		'HTA_W'			 => 9042, // write
		'HTA_GET'		 => 9030, // failed to get
	);

	/**
	 * Throw an error with msg
	 *
	 * @since  3.0
	 */
	public static function t( $code, $args = null )
	{
		throw new \Exception( self::msg( $code, $args ) );
	}

	/**
	 * Translate an error to description
	 *
	 * @since  3.0
	 */
	public static function msg( $code, $args = null )
	{
		switch ( $code ) {

			case 'disabled_all':
				$msg = sprintf( __( 'The setting %s is currently enabled.', 'litespeed-cache' ), '<strong>' . Lang::title( Base::O_DEBUG_DISABLE_ALL ) . '</strong>' ) .
					' ' . sprintf( __( '<a %s>Click here to change</a>.', 'litespeed-cache' ), ' href="' . admin_url('admin.php?page=litespeed-debug') . '" ' );
				break;

			case 'lack_of_api_key':
				$msg = sprintf( __( 'You will need to set %s to use the online services.', 'litespeed-cache' ), '<strong>' . Lang::title( Base::O_API_KEY ) . '</strong>' ) .
					' ' . sprintf( __( '<a %2$s>Click here to set</a>.', 'litespeed-cache' ), ' href="' . admin_url('admin.php?page=litespeed-general') . '" ' );
				break;

			case 'lack_of_quota':
				$msg = __( 'You don\'t have enough quota for current service left this month.', 'litespeed-cache' );
				break;

			case 'empty_list':
				$msg = __( 'The image list is empty.', 'litespeed-cache' );
				break;

			case 'lack_of_param' :
				$msg = __( 'Not enough parameters. Please check if the domain key is set correctly', 'litespeed-cache' );
				break;

			case 'unfinished_queue' :
				$msg = __( 'There is proceeding queue not pulled yet.', 'litespeed-cache' );
				break;

			case 'err_key' :
				$msg = __( 'The domain key is not correct. Please try to sync your domain key again.', 'litespeed-cache' );
				break;

			case 'err_overdraw' :
				$msg = __( 'Credits are not enough to proceed the current request.', 'litespeed-cache' );
				break;

			case 'W' :
				$msg = __( '%s file not writable.', 'litespeed-cache' );
				break;

			case 'HTA_DNF' :
				if ( ! is_array( $args ) ) {
					$args = array( '<code>' . $args . '</code>' );
				}
				$args[] = '.htaccess';
				$msg = __( 'Could not find %1$s in %2$s.', 'litespeed-cache' );
				break;

			case 'HTA_LOGIN_COOKIE_INVALID' :
				$msg = sprintf( __( 'Invalid login cookie. Please check the %s file.', 'litespeed-cache' ), '.htaccess' );
				break;

			case 'HTA_BK' :
				$msg = sprintf( __( 'Failed to back up %s file, aborted changes.', 'litespeed-cache' ), '.htaccess' );
				break;

			case 'HTA_R' :
				$msg = sprintf( __( '%s file not readable.', 'litespeed-cache' ), '.htaccess' );
				break;

			case 'HTA_W' :
				$msg = sprintf( __( '%s file not writable.', 'litespeed-cache' ), '.htaccess' );
				break;

			case 'HTA_GET' :
				$msg = sprintf( __( 'Failed to get %s file contents.', 'litespeed-cache' ), '.htaccess' );
				break;

			case 'failed_tb_creation' :
				$msg = __( 'Failed to create table %s! SQL: %s.', 'litespeed-cache' );
				break;

			case 'crawler_disabled' :
				$msg = __( 'Crawler disabled by the server admin.', 'litespeed-cache' );
				break;

			default:
				$msg = __( 'Unknown error', 'litespeed-cache' ) . ': ' . $code;
				break;
		}

		if ( $args !== null ) {
			$msg = is_array( $args ) ? vsprintf( $msg, $args ) : sprintf( $msg, $args );
		}

		if ( isset( self::$CODE_SET[ $code ] ) ) {
			$msg = 'ERROR ' . self::$CODE_SET[ $code ] . ': ' . $msg;
		}

		return $msg;
	}
}