<?php

namespace App\Http\Controllers\Backend\Theme;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Services\Theme\AppearanceService;
use App\Transformers\AppearanceTransformer;
use App\SM\SM;

class AppearanceController extends Controller
{


    /**
     * @var TaskCreateService
     */
    private $systemService;
    /**
     * @var TaskCreateTransformer
     */
    private $systemTransformer;

    /**
     * TaskCreateController constructor.
     * @param AppearanceService $systemService
     * @param AppearanceRepositories $systemTransformer
     */
    public function __construct(AppearanceService $taskCreateService, AppearanceTransformer $taskCreateTransformer)
    {
        $this->systemService = $taskCreateService;
        $this->systemTransformer = $taskCreateTransformer;
    }


    public function themeOptions() {
        $title = 'Theme Option';
		$file = resource_path( "views/backend/pages/theme/themeOptions.php");
		if ( file_exists( $file ) ) {
			$smThemeOptions = require_once $file;
		} else {
			$smThemeOptions = array();
		}

		return view( 'backend/pages/theme/themeOption', get_defined_vars());
	}

	public function saveSmThemeOptions( Request $request ) {


		

	


		$this->validate( $request, ["sm_theme_options" => "required|array" ]);
		
		foreach ( $request->sm_theme_options as $section => $fields ) {
			$sl=0;
			foreach ($fields as $settingKey => $settingValue ) {


				$newFormattedSettingValue = [];
				foreach ($settingValue as $key => $value ) {
					if ( is_array( $value ) ) {
						$newLoop=[];
						foreach ($value as $single){
							try{
								$newLoop[]= json_decode($single, true);
							} catch (\Exception $e) {
								
							}
						}
						$newFormattedSettingValue[ $key ] = $newLoop;
					} else {
						if($value){
							$newFormattedSettingValue[ $key ] = $value;
						}
						
					}
				}
				$setting_option_name = "sm_theme_options_$settingKey";
				$smoption= SM::sm_serialize( $newFormattedSettingValue, array() );
				SM::update_setting( $setting_option_name, $smoption );
				$sl++;

				
			}
		}
		
		if ( $request->isXmlHttpRequest() ) {
			return response( "Successfully Saved!", 200 );
		} else {
			return back()->with( "s_message", "Successfully Saved!" );
		}
	}


	function isJson($string) {

		


		try{

			json_decode($string);
			return json_last_error() === JSON_ERROR_NONE;

	} catch (\Exception $e) {
		
		return false;
	}


		
	 }



/**
	 * Show File editor and file
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function editor( Request $request ) {
        $title = 'Edit or Modify in controller';
		if ( $request->ajax() ) {
			if ( $request->method() == 'POST' ) {
				/**
				 * Show file info
				 */
				if ( $request->has( 'dir' ) && $request->has( 'filename' ) ) {
					$dir      = $request->input( 'dir' );
					$filename = $request->input( 'filename' );
					$file     = $dir . DIRECTORY_SEPARATOR . $filename;
					if ( File::hash( $file ) ) {
						$data['isSuccess'] = 1;
						$data['contents']  = File::get( $file );
					} else {
						$data['isSuccess'] = 0;
						$data['message']   = "File not found!";
					}
				} else {
					$data['isSuccess'] = 0;
					$data['message']   = "Filename or Directory not found!";
				}

				return response()->json( $data );
			} else {
				/**
				 * Return directory info
				 */
				return response( $this->generateTreeHtml( $request ) );
			}
		} else {
			/**
			 * Return editor layout
			 */
			return view( 'backend/pages/theme/editor',get_defined_vars());
		}
	}


	private function generateTreeHtml( Request $request ) {
		$body        = '';
		$path        = $request->input( "directory", base_path() );
		$directories = File::directories( $path );
		if ( count( $directories ) > 0 ) {
			foreach ( $directories as $dir ) {
				$name = basename( $dir );
				$body .= '<li class="jstree-closed" data-is-dir="1" data-dir="' . $dir . '">' . $name . '</li>';
			}
		}
		$files = File::files( $path );
		if ( count( $files ) > 0 ) {
			foreach ( $files as $file ) {
				$name              = $file->getFilename();
				$ext               = strtolower( pathinfo( $name, PATHINFO_EXTENSION ) );
				$icon              = $this->getFileIcon( $ext );
				$checkEditableFile = $this->checkEditableFile( $ext );
				$path              = $file->getPath();
				$body              .= '<li ';
				$body              .= 'data-jstree=\'{"icon":"' . $icon . '"}\' ';
				$body              .= 'data-is-dir="0" ';
				$body              .= 'data-dir="' . $path . '" ';
				$body              .= 'data-iswritable="' . $checkEditableFile['isAllowedEditableFile'] . '" ';
				$body              .= 'data-type="' . $checkEditableFile['type'] . '" ';
				$body              .= 'data-filename="' . $name . '" ';
				$body              .= '>' . $name . '</li>';
			}
		}
		if ( $request->has( "directory" ) ) {
			$header = '<ul>';
			$footer = '</ul>';
			$html   = $header . $body . $footer;
		} else {
			$header = '<li data-jstree=\'{"opened":true,"selected":true}\'>' . SM::sm_get_site_name();
			$header .= '<ul>';
			$footer = '</ul>';
			$footer .= '</li>';
			$html   = $header . $body . $footer;
		}

		return $html;
	}

	private function getFileIcon( $ext ) {
		$icon = 'file.png';
		if ( $ext == 'php' ) {
			$icon = 'php.png';
		} elseif ( $ext == 'css' ) {
			$icon = 'css.png';
		} elseif ( $ext == 'js' ) {
			$icon = 'js.png';
		} elseif ( $ext == 'json' ) {
			$icon = 'json.png';
		} elseif ( $ext == 'html' || $ext == 'htm' ) {
			$icon = 'html.png';
		} elseif ( $ext == 'md' ) {
			$icon = 'md.png';
		} elseif ( $ext == 'xml' ) {
			$icon = 'xml.png';
		}

		return asset( 'nptl-admin/img/file_icon/' . $icon );
	}

	private function checkEditableFile( $ext ) {
		if ( $ext == 'php' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'php';
		} elseif ( $ext == 'css' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'css';
		} elseif ( $ext == 'js' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'javascript';
		} elseif ( $ext == 'html' || $ext == 'html' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'html';
		} elseif ( $ext == 'md' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'markdown';
		} elseif ( $ext == 'json' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'json';
		} elseif ( $ext == 'xml' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'xml';
		} elseif ( $ext == 'log' ) {
			$data['isAllowedEditableFile'] = 1;
			$data['type']                  = 'log';
		}  else {
			$data['isAllowedEditableFile'] = 0;
			$data['type']                  = '';
		}

		return $data;
	}

	public function saveEditor( Request $request ) {
		if ( $request->has( 'dir' ) && $request->has( 'filename' ) ) {
			$dir               = $request->input( 'dir' );
			$filename          = $request->input( 'filename' );
			$ext               = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );
			$checkEditableFile = $this->checkEditableFile( $ext );
			if ( $checkEditableFile['isAllowedEditableFile'] == 1 ) {
				$file = $dir . DIRECTORY_SEPARATOR . $filename;
				if ( File::hash( $file ) ) {
					$content       = $request->input( 'content' );
					$bytes_written = File::put( $file, $content );
					if ( $bytes_written === false ) {
						$data['isSuccess'] = 0;
						$data['message']   = "File Written Failed!";
					} else {
						$data['isSuccess'] = 1;
						$data['message']   = ucfirst( $filename ) . " file updated successfully!";
					}
				} else {
					$data['isSuccess'] = 0;
					$data['message']   = "File not found!";
				}
			} else {
				$data['isSuccess'] = 0;
				$data['message']   = "We don't support this file update";
			}
		} else {
			$data['isSuccess'] = 0;
			$data['message']   = "Filename or Directory not found!";
		}

		return response()->json( $data );
	}




}



?>