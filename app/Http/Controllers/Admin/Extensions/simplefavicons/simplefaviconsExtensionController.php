<?php

namespace Pterodactyl\Http\Controllers\Admin\Extensions\simplefavicons;

use Illuminate\View\View;
use Illuminate\View\Factory as ViewFactory;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Services\Helpers\SoftwareVersionService;
use Pterodactyl\Http\Requests\Admin\AdminFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Pterodactyl\BlueprintFramework\Libraries\ExtensionLibrary\Admin\BlueprintAdminLibrary as BlueprintExtensionLibrary;
use Illuminate\Http\Response;


class simplefaviconsExtensionController extends Controller {

  /**
   * simplefaviconsExtensionController constructor.
   */
  public function __construct(
    private BlueprintExtensionLibrary $blueprint,
    private SoftwareVersionService $version,
    private ViewFactory $view,
    private SettingsRepositoryInterface $settings,
    private ConfigRepository $config
  ){}

  /**
   * Return the extension index view.
   */
  public function index(): View
  {
    $db_status = $this->blueprint->dbGet('simplefavicons', 'status');
    $file_path = $this->blueprint->dbGet('simplefavicons', 'file_path');

    
    if($db_status == "") {
      $defaultDb_status = "true";
      $this->blueprint->dbSet('simplefavicons', 'status', "$defaultDb_status");
      $db_status = $this->blueprint->dbGet('simplefavicons', 'status');
    }

    if($file_path == "") {
        $this->blueprint->dbSet('simplefavicons', 'file_path', "No file uploaded");
        $file_path = $this->blueprint->dbGet('simplefavicons', 'file_path');
      }
    

    return $this->view->make('admin.extensions.simplefavicons.index', [
      'blueprint' => $this->blueprint,

      'db_status' => $db_status,
      'file_path' => $file_path,
  
      'version' => $this->version,
      'root' => "/admin/extensions/simplefavicons"
    ]);
  }
  
  // ...
  
  public function post(Request $request)
  {
    if ($request->hasFile('file')) {

          $file = $request->file('file');
          
          // Store the file in the public folder
          $path = $file->store('public');

          $file_path = \Storage::url($path);
          $url = asset($file_path);
          
          $this->blueprint->dbSet('simplefavicons', 'file_path', "$url");
          return redirect()->route('admin.extensions.simplefavicons.index');

    }
    return redirect()->route('admin.extensions.simplefavicons.index');

  }


  /**
   * @throws \Pterodactyl\Exceptions\Model\DataValidationException
   * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
   */
  public function update(simplefaviconsSettingsFormRequest $request): RedirectResponse
  {
    foreach ($request->normalize() as $key => $value) {
      $this->settings->set('simplefavicons::' . $key, $value);
    }

    return redirect()->route('admin.extensions.simplefavicons.index');
  }
}

class simplefaviconsSettingsFormRequest extends AdminFormRequest
{
  public function rules(): array
  {
    return [
      'status' => 'string',
      'file_path' => 'string',
    ];
  }

  public function attributes(): array
  {
    return [
      'status' => 'simplefavicons icon status',
      'file_path' => 'simplefavicons icon',
    ];
  }
}