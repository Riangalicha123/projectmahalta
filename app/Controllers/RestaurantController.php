<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenubarbeerModel;
use App\Models\MenubarbucketModel;
use App\Models\MenubarcocktailModel;
use App\Models\MenubarjuiceModel;
use App\Models\MenubarmocktailModel;
use App\Models\MenubarModel;
use App\Models\MenubarredwineModel;
use App\Models\MenubarshakeModel;
use App\Models\MenubarshooterModel;
use App\Models\MenubartowerModel;
use App\Models\MenubarliquorModel;
use App\Models\MenucafeModel;
use App\Models\MenucafecoldModel;
use App\Models\MenucafehotModel;
use App\Models\MenucafeicedModel;

use App\Models\MenumainbreakfastModel;
use App\Models\MenumainveggiesModel;
use App\Models\MenumainsoupModel;
use App\Models\MenumainsolomealModel;
use App\Models\MenumainchickenModel;
use App\Models\MenumainsnackModel;
use App\Models\MenumainsizzlingModel;
use App\Models\MenumainseafoodModel;
use App\Models\MenumainporkModel;
use App\Models\MenumainpastaModel;
use App\Models\MenumainModel;
use App\Models\MenumainmealdealsModel;
use App\Traits\EmailTrait;

class RestaurantController extends BaseController
{
    use EmailTrait;
    private $beers;
    private $buckets;
    private $cocktails;
    private $mocktails;
    private $juices;
    private $liquors;
    private $redwines;
    private $shakes;
    private $shooters;
    private $towers;
    private $bars;
    private $cafes;
    private $colds;
    private $hots;
    private $iced;
    private $mains;
    private $breakfasts;
    private $chickens;
    private $mealdeals;
    private $pastas;
    private $porks;
    private $seafoods;
    private $sizzlings;
    private $snacks;
    private $solomeals;
    private $soups;
    private $veggies;
    
    function __construct(){
        helper(['form']);
        $this->bar = new MenubarModel();
        $this->beers = new MenubarbeerModel();
        $this->buckets = new MenubarbucketModel();
        $this->cocktails = new MenubarcocktailModel();
        $this->juices = new MenubarjuiceModel();
        $this->liquors = new MenubarliquorModel();
        $this->mocktails = new MenubarmocktailModel();
        $this->redwines = new MenubarredwineModel();
        $this->shakes = new MenubarshakeModel();
        $this->shooters = new MenubarshooterModel();
        $this->towers = new MenubartowerModel();

        $this->cafes = new MenucafeModel();
        $this->colds = new MenucafecoldModel();
        $this->hots = new MenucafehotModel();
        $this->iced = new MenucafeicedModel();
        
        $this->mains = new MenumainModel();
        $this->breakfasts = new MenumainbreakfastModel();
        $this->chickens = new MenumainchickenModel();
        $this->mealdeals = new MenumainmealdealsModel();
        $this->pastas = new MenumainpastaModel();
        $this->porks = new MenumainporkModel();
        $this->seafoods = new MenumainseafoodModel();
        $this->sizzlings = new MenumainsizzlingModel();
        $this->snacks = new MenumainsnackModel();
        $this->solomeals = new MenumainsolomealModel();
        $this->soups = new MenumainsoupModel();
        $this->veggies = new MenumainveggiesModel();
        
    }

    public function index()
    {
        //
    }
    public function addCocktails(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'CocktailsID' => $this->request->getVar('CocktailsID'),
                'CocktailsName' => $this->request->getVar('CocktailsName'),
                'CocktailsPrice' => $this->request->getVar('CocktailsPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->cocktails->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateCocktails(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'CocktailsID' => $this->request->getVar('CocktailsID'),
                'CocktailsName' => $this->request->getVar('CocktailsName'),
                'CocktailsPrice' => $this->request->getVar('CocktailsPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->cocktails->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addMocktails(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'MocktailsID' => $this->request->getVar('MocktailsID'),
                'MocktailsName' => $this->request->getVar('MocktailsName'),
                'MocktailsPrice' => $this->request->getVar('MocktailsPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->mocktails->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateMocktails(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'MocktailsID' => $this->request->getVar('MocktailsID'),
                'MocktailsName' => $this->request->getVar('MocktailsName'),
                'MocktailsPrice' => $this->request->getVar('MocktailsPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->mocktails->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addShooters(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'ShootersID' => $this->request->getVar('ShootersID'),
                'ShootersName' => $this->request->getVar('ShootersName'),
                'ShootersPrice' => $this->request->getVar('ShootersPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->shooters->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateShooters(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'ShootersID' => $this->request->getVar('ShootersID'),
                'ShootersName' => $this->request->getVar('ShootersName'),
                'ShootersPrice' => $this->request->getVar('ShootersPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->shooters->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addTower(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'TowerID' => $this->request->getVar('TowerID'),
                'TowerName' => $this->request->getVar('TowerName'),
                'TowerPrice' => $this->request->getVar('TowerPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->towers->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateTower(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'TowerID' => $this->request->getVar('TowerID'),
                'TowerName' => $this->request->getVar('TowerName'),
                'TowerPrice' => $this->request->getVar('TowerPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->towers->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addJuices(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'JuicesID' => $this->request->getVar('JuicesID'),
                'JuicesName' => $this->request->getVar('JuicesName'),
                'JuicesPrice' => $this->request->getVar('JuicesPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->juices->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateJuices(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'JuicesID' => $this->request->getVar('JuicesID'),
                'JuicesName' => $this->request->getVar('JuicesName'),
                'JuicesPrice' => $this->request->getVar('JuicesPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->juices->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addShakes(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'ShakesID' => $this->request->getVar('ShakesID'),
                'ShakesName' => $this->request->getVar('ShakesName'),
                'ShakesPrice' => $this->request->getVar('ShakesPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->shakes->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateShakes(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'ShakesID' => $this->request->getVar('ShakesID'),
                'ShakesName' => $this->request->getVar('ShakesName'),
                'ShakesPrice' => $this->request->getVar('ShakesPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->shakes->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addLiquors(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'LiquorsID' => $this->request->getVar('LiquorsID'),
                'LiquorsName' => $this->request->getVar('LiquorsName'),
                'LiquorsPrice' => $this->request->getVar('LiquorsPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->liquors->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateLiquors(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'LiquorsID' => $this->request->getVar('LiquorsID'),
                'LiquorsName' => $this->request->getVar('LiquorsName'),
                'LiquorsPrice' => $this->request->getVar('LiquorsPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->liquors->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addRedwine(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'RedwineID' => $this->request->getVar('RedwineID'),
                'RedwineName' => $this->request->getVar('RedwineName'),
                'RedwinePrice' => $this->request->getVar('RedwinePrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->redwines->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateRedwine(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'RedwineID' => $this->request->getVar('RedwineID'),
                'RedwineName' => $this->request->getVar('RedwineName'),
                'RedwinePrice' => $this->request->getVar('RedwinePrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->redwines->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addBeer(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'BeerID' => $this->request->getVar('BeerID'),
                'BeerName' => $this->request->getVar('BeerName'),
                'BeerPrice' => $this->request->getVar('BeerPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->beers->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateBeer(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'BeerID' => $this->request->getVar('BeerID'),
                'BeerName' => $this->request->getVar('BeerName'),
                'BeerPrice' => $this->request->getVar('BeerPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->beers->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addBucket(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'BucketID' => $this->request->getVar('BucketID'),
                'BucketName' => $this->request->getVar('BucketName'),
                'BucketPrice' => $this->request->getVar('BucketPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->buckets->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateBucket(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'BucketID' => $this->request->getVar('BucketID'),
                'BucketName' => $this->request->getVar('BucketName'),
                'BucketPrice' => $this->request->getVar('BucketPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->buckets->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addIced(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'IcedID' => $this->request->getVar('IcedID'),
                'IcedName' => $this->request->getVar('IcedName'),
                'IcedPriceTall' => $this->request->getVar('IcedPriceTall'),
                'IcedPriceGrande' => $this->request->getVar('IcedPriceGrande'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->iced->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateIced(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'IcedID' => $this->request->getVar('IcedID'),
                'IcedName' => $this->request->getVar('IcedName'),
                'IcedPriceTall' => $this->request->getVar('IcedPriceTall'),
                'IcedPriceGrande' => $this->request->getVar('IcedPriceGrande'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->iced->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addHot(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'HotID' => $this->request->getVar('HotID'),
                'HotName' => $this->request->getVar('HotName'),
                'HotPrice' => $this->request->getVar('HotPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->hots->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateHot(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'HotID' => $this->request->getVar('HotID'),
                'HotName' => $this->request->getVar('HotName'),
                'HotPrice' => $this->request->getVar('HotPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->hots->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function addCold(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'ColdID' => $this->request->getVar('ColdID'),
                'ColdName' => $this->request->getVar('ColdName'),
                'ColdPrice' => $this->request->getVar('ColdPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->colds->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }
    public function updateCold(){

        $file = $this->request->getFile('Image');
    
        // Check if a file is uploaded
        if ($file) {
            $newFileName = $file->getRandomName();
    
            $data = [
                'ColdID' => $this->request->getVar('ColdID'),
                'ColdName' => $this->request->getVar('ColdName'),
                'ColdPrice' => $this->request->getVar('ColdPrice'),
                'Image'                => $newFileName
            ];
    
            $rules = [
                'Image' => [
                    'uploaded[Image]',
                    'max_size[Image,10240]', // Maximum file size in kilobytes (adjust as needed)
                    'ext_in[Image,png,jpg,gif]' // Allow only files with the specified extensions
                ]
            ];
    
            // Validate the file and other form data
            if ($this->validate($rules)) {
                // Check if the file is valid and has not been moved
                if ($file->isValid() && !$file->hasMoved()) {
                    // Move the file to the 'uploads' directory
                    if ($file->move(FCPATH . 'restaurant/', $newFileName)) {
                        // Save product data to the database
                        $this->colds->save($data);
                        
                    } else {
                        // Handle file move error
                        echo $file->getErrorString() . ' ' . $file->getError();
                    }
                }
            } else {
                // Handle validation errors
                $data['validation'] = $this->validator;
            }
        } else {
            echo('error');
        }
        return redirect()->to('/admin-restaurant/service');
    }

}
