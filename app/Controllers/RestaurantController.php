<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use App\Models\MenuProductModel;
use App\Models\MenuCategoryModel;
use App\Models\MenuProductIcedModel;
use App\Traits\EmailTrait;

class RestaurantController extends BaseController
{
    use EmailTrait;
    private $menus;
    private $products;
    private $categories;
    private $iced;
    
    function __construct(){
        helper(['form']);
        $this->menus = new MenuModel();
        $this->products = new MenuProductModel();
        $this->categories = new MenuCategoryModel();
        $this->iced = new MenuProductIcedModel();
    }
    public function addMainMenu()
    {
        helper(['form']);
    
        // Validation Rules
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
    
        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
    
        // Retrieve Category ID
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
    
        // Retrieve Menu ID for Main Menu
        $inputMainMenu = 'Main Menu';
        $menuMain = $this->menus->where('MenuType', $inputMainMenu)->first();
    
        // Check if both category and main menu exist
        if ($menuCategory && $menuMain) {
            // Upload and process image
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Please upload an image.');
            }
    
            // Insert new menu item
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuMain['MenuID'],
                'Image' => $newFileName
            ];
    
            // Insert menu item
            $inserted = $this->products->insert($newMenuData);
            if ($inserted) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item added successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to add menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function updateMainMenu()
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }

        // Retrieve Product ID
        $productID = $this->request->getPost('ProductID');

        // Retrieve Category ID
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();

        // Retrieve Menu ID for Main Menu
        $inputMainMenu = 'Main Menu';
        $menuMain = $this->menus->where('MenuType', $inputMainMenu)->first();

        // Check if both category and main menu exist
        if ($menuCategory && $menuMain) {
            // Upload and process image
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // If no new image is uploaded, retain the existing image filename
                $newFileName = $this->request->getPost('Image');
            }

            // Update menu item data
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuMain['MenuID'],
                'Image' => $newFileName
            ];

            // Update menu item
            $updated = $this->products->update($productID, $updatedMenuData);
            if ($updated) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item updated successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to update menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function addBarMenu()
    {
        helper(['form']);
    
        // Validation Rules
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
    
        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
    
        // Retrieve Category ID
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
    
        // Retrieve Menu ID for Bar Menu
        $inputBarMenu = 'Bar Menu';
        $menuBar = $this->menus->where('MenuType', $inputBarMenu)->first();
    
        // Check if both category and Bar menu exist
        if ($menuCategory && $menuBar) {
            // Upload and process image
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Please upload an image.');
            }
    
            // Insert new menu item
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuBar['MenuID'],
                'Image' => $newFileName
            ];
    
            // Insert menu item
            $inserted = $this->products->insert($newMenuData);
            if ($inserted) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item added successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to add menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function updateBarMenu()
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }

        // Retrieve Product ID
        $productID = $this->request->getPost('ProductID');

        // Retrieve Category ID
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();

        // Retrieve Menu ID for Bar Menu
        $inputBarMenu = 'Bar Menu';
        $menuBar = $this->menus->where('MenuType', $inputBarMenu)->first();

        // Check if both category and Bar menu exist
        if ($menuCategory && $menuBar) {
            // Upload and process image
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // If no new image is uploaded, retain the existing image filename
                $newFileName = $this->request->getPost('Image');
            }

            // Update menu item data
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuBar['MenuID'],
                'Image' => $newFileName
            ];

            // Update menu item
            $updated = $this->products->update($productID, $updatedMenuData);
            if ($updated) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item updated successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to update menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function addCafeMenu()
    {
        helper(['form']);
    
        // Validation Rules
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
    
        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
    
        // Retrieve Category ID
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
    
        // Retrieve Menu ID for Cafe Menu
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
    
        // Check if both category and Cafe menu exist
        if ($menuCategory && $menuCafe) {
            // Upload and process image
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Please upload an image.');
            }
    
            // Insert new menu item
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
    
            // Insert menu item
            $inserted = $this->products->insert($newMenuData);
            if ($inserted) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item added successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to add menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function updateCafeMenu()
    {
        helper(['form']);

        // Validation Rules
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];

        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }

        // Retrieve Product ID
        $productID = $this->request->getPost('ProductID');

        // Retrieve Category ID
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();

        // Retrieve Menu ID for Cafe Menu
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();

        // Check if both category and Cafe menu exist
        if ($menuCategory && $menuCafe) {
            // Upload and process image
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // If no new image is uploaded, retain the existing image filename
                $newFileName = $this->request->getPost('Image');
            }

            // Update menu item data
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];

            // Update menu item
            $updated = $this->products->update($productID, $updatedMenuData);
            if ($updated) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item updated successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to update menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function addCafeMenuIced()
    {
        helper(['form']);
    
        // Validation Rules
        $validationRules = [
            
            'IcedName' => 'required',
            'PriceTall' => 'required',
            'PriceGrande' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
    
        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
    
        // Retrieve Category ID
        $inputCategoryName = 'Iced Coffee';
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
    
        // Retrieve Menu ID for Cafe Menu
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
    
        // Check if both category and Cafe menu exist
        if ($menuCategory && $menuCafe) {
            // Upload and process image
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Please upload an image.');
            }
    
            // Insert new menu item
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'IcedName' => $this->request->getPost('IcedName'),
                'PriceTall' => $this->request->getPost('PriceTall'),
                'PriceGrande' => $this->request->getPost('PriceGrande'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
    
            // Insert menu item
            $inserted = $this->iced->insert($newMenuData);
            if ($inserted) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item added successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to add menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function updateCafeMenuIced()
    {
        helper(['form']);
    
        // Validation Rules
        $validationRules = [
            'IcedName' => 'required',
            'PriceTall' => 'required',
            'PriceGrande' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
    
        // Validate Input
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
    
        // Retrieve Product ID
        $productID = $this->request->getPost('IcedID'); // Corrected to retrieve IcedID instead of ProductID
    
        // Retrieve Category ID
        $inputCategoryName = 'Iced Coffee';
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
    
        // Retrieve Menu ID for Cafe Menu
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
    
        // Check if both category and Cafe menu exist
        if ($menuCategory && $menuCafe) {
            // Upload and process image
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // If no new image is uploaded, retain the existing image filename
                $newFileName = $this->request->getPost('Image');
            }
    
            // Update menu item data
            $updatedMenuData = [
                'IcedName' => $this->request->getPost('IcedName'),
                'PriceTall' => $this->request->getPost('PriceTall'),
                'PriceGrande' => $this->request->getPost('PriceGrande'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
    
            // Update menu item
            $updated = $this->iced->update($productID, $updatedMenuData);
            if ($updated) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item updated successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to update menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    
    

    
}
