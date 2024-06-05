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
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputMainMenu = 'Main Menu';
        $menuMain = $this->menus->where('MenuType', $inputMainMenu)->first();
        if ($menuCategory && $menuMain) {
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
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuMain['MenuID'],
                'Image' => $newFileName
            ];
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
    public function deleteMainMenu($productID)
    {
        $product = $this->products->find($productID);
        if ($product) {
            $deleted = $this->products->delete($productID);
            if ($deleted) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Menu item not found.');
        }
    }
    public function updateMainMenu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
    
        $productID = $this->request->getPost('ProductID');
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputMainMenu = 'Main Menu';
        $menuMain = $this->menus->where('MenuType', $inputMainMenu)->first();
    
        if ($menuCategory && $menuMain) {
            $newFileName = null;
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    // Fetch the current product data
                    $currentProduct = $this->products->find($productID);
                    if ($currentProduct && !empty($currentProduct['Image'])) {
                        // Delete the old image
                        $oldFilePath = FCPATH . 'restaurant/' . $currentProduct['Image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Save the new image
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // Use existing image if no new image is uploaded
                $newFileName = $this->request->getPost('Image');
            }
    
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuMain['MenuID'],
                'Image' => $newFileName
            ];
    
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
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputBarMenu = 'Bar Menu';
        $menuBar = $this->menus->where('MenuType', $inputBarMenu)->first();
        if ($menuCategory && $menuBar) {
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
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuBar['MenuID'],
                'Image' => $newFileName
            ];
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
    public function deleteBarMenu($productID)
    {
        $product = $this->products->find($productID);
        if ($product) {
            $deleted = $this->products->delete($productID);
            if ($deleted) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Menu item not found.');
        }
    }
    public function updateBarMenu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
        $productID = $this->request->getPost('ProductID');
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputBarMenu = 'Bar Menu';
        $menuBar = $this->menus->where('MenuType', $inputBarMenu)->first();
        if ($menuCategory && $menuBar) {
            $newFileName = null;
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    // Fetch the current product data
                    $currentProduct = $this->products->find($productID);
                    if ($currentProduct && !empty($currentProduct['Image'])) {
                        // Delete the old image
                        $oldFilePath = FCPATH . 'restaurant/' . $currentProduct['Image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Save the new image
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // Use existing image if no new image is uploaded
                $newFileName = $this->request->getPost('Image');
            }
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuBar['MenuID'],
                'Image' => $newFileName
            ];
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
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
        if ($menuCategory && $menuCafe) {
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
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
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
    public function deleteCafeMenu($productID)
    {
        $product = $this->products->find($productID);
        if ($product) {
            $deleted = $this->products->delete($productID);
            if ($deleted) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Menu item not found.');
        }
    }
    public function updateCafeMenu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
        $productID = $this->request->getPost('ProductID');
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
        if ($menuCategory && $menuCafe) {
            $newFileName = null;
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    // Fetch the current product data
                    $currentProduct = $this->products->find($productID);
                    if ($currentProduct && !empty($currentProduct['Image'])) {
                        // Delete the old image
                        $oldFilePath = FCPATH . 'restaurant/' . $currentProduct['Image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Save the new image
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // Use existing image if no new image is uploaded
                $newFileName = $this->request->getPost('Image');
            }
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
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
        $validationRules = [
            
            'IcedName' => 'required',
            'PriceTall' => 'required',
            'PriceGrande' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
        $inputCategoryName = 'Iced Coffee';
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
        if ($menuCategory && $menuCafe) {
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
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'IcedName' => $this->request->getPost('IcedName'),
                'PriceTall' => $this->request->getPost('PriceTall'),
                'PriceGrande' => $this->request->getPost('PriceGrande'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
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
    public function deleteCafeMenuIced($icedID)
    {
        $iced = $this->iced->find($icedID);
        if ($iced) {
            $deleted = $this->iced->delete($icedID);
            if ($deleted) {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Menu item not found.');
        }
    }
    public function updateCafeMenuIced()
    {
        helper(['form']);
        $validationRules = [
            'IcedName' => 'required',
            'PriceTall' => 'required',
            'PriceGrande' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
        $productID = $this->request->getPost('IcedID'); 
        $inputCategoryName = 'Iced Coffee';
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
        if ($menuCategory && $menuCafe) {
            $newFileName = null;
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    // Fetch the current product data
                    $currentProduct = $this->products->find($productID);
                    if ($currentProduct && !empty($currentProduct['Image'])) {
                        // Delete the old image
                        $oldFilePath = FCPATH . 'restaurant/' . $currentProduct['Image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Save the new image
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/admin-restaurant/service'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // Use existing image if no new image is uploaded
                $newFileName = $this->request->getPost('Image');
            }
            $updatedMenuData = [
                'IcedName' => $this->request->getPost('IcedName'),
                'PriceTall' => $this->request->getPost('PriceTall'),
                'PriceGrande' => $this->request->getPost('PriceGrande'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
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
    //Staff
    public function addMainMenuu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/admin-restaurant/service'))->with('validationErrors', $validationErrors);
        }
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputMainMenu = 'Main Menu';
        $menuMain = $this->menus->where('MenuType', $inputMainMenu)->first();
        if ($menuCategory && $menuMain) {
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Please upload an image.');
            }
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuMain['MenuID'],
                'Image' => $newFileName
            ];
            $inserted = $this->products->insert($newMenuData);
            if ($inserted) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item added successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to add menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function deleteMainMenuu($productID)
    {
        $product = $this->products->find($productID);
        if ($product) {
            $deleted = $this->products->delete($productID);
            if ($deleted) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Menu item not found.');
        }
    }
    public function updateMainMenuu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('validationErrors', $validationErrors);
        }
        $productID = $this->request->getPost('ProductID');
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputMainMenu = 'Main Menu';
        $menuMain = $this->menus->where('MenuType', $inputMainMenu)->first();
        if ($menuCategory && $menuMain) {
            $newFileName = null;
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    // Fetch the current product data
                    $currentProduct = $this->products->find($productID);
                    if ($currentProduct && !empty($currentProduct['Image'])) {
                        // Delete the old image
                        $oldFilePath = FCPATH . 'restaurant/' . $currentProduct['Image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Save the new image
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // Use existing image if no new image is uploaded
                $newFileName = $this->request->getPost('Image');
            }
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuMain['MenuID'],
                'Image' => $newFileName
            ];
            $updated = $this->products->update($productID, $updatedMenuData);
            if ($updated) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item updated successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to update menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function addBarMenuu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('validationErrors', $validationErrors);
        }
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputBarMenu = 'Bar Menu';
        $menuBar = $this->menus->where('MenuType', $inputBarMenu)->first();
        if ($menuCategory && $menuBar) {
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Please upload an image.');
            }
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuBar['MenuID'],
                'Image' => $newFileName
            ];
            $inserted = $this->products->insert($newMenuData);
            if ($inserted) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item added successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to add menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function deleteBarMenuu($productID)
    {
        $product = $this->products->find($productID);
        if ($product) {
            $deleted = $this->products->delete($productID);
            if ($deleted) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Menu item not found.');
        }
    }
    public function updateBarMenuu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('validationErrors', $validationErrors);
        }
        $productID = $this->request->getPost('ProductID');
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputBarMenu = 'Bar Menu';
        $menuBar = $this->menus->where('MenuType', $inputBarMenu)->first();
        if ($menuCategory && $menuBar) {
            $newFileName = null;
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    // Fetch the current product data
                    $currentProduct = $this->products->find($productID);
                    if ($currentProduct && !empty($currentProduct['Image'])) {
                        // Delete the old image
                        $oldFilePath = FCPATH . 'restaurant/' . $currentProduct['Image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Save the new image
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // Use existing image if no new image is uploaded
                $newFileName = $this->request->getPost('Image');
            }
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuBar['MenuID'],
                'Image' => $newFileName
            ];
            $updated = $this->products->update($productID, $updatedMenuData);
            if ($updated) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item updated successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to update menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function addCafeMenuu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('validationErrors', $validationErrors);
        }
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
        if ($menuCategory && $menuCafe) {
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Please upload an image.');
            }
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
            $inserted = $this->products->insert($newMenuData);
            if ($inserted) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item added successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to add menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function deleteCafeMenuu($productID)
    {
        $product = $this->products->find($productID);
        if ($product) {
            $deleted = $this->products->delete($productID);
            if ($deleted) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Menu item not found.');
        }
    }
    public function updateCafeMenuu()
    {
        helper(['form']);
        $validationRules = [
            'CategoryName' => 'required',
            'ProductName' => 'required',
            'ProductPrice' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('validationErrors', $validationErrors);
        }
        $productID = $this->request->getPost('ProductID');
        $inputCategoryName = $this->request->getPost('CategoryName');
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
        if ($menuCategory && $menuCafe) {
            $newFileName = null;
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    // Fetch the current product data
                    $currentProduct = $this->products->find($productID);
                    if ($currentProduct && !empty($currentProduct['Image'])) {
                        // Delete the old image
                        $oldFilePath = FCPATH . 'restaurant/' . $currentProduct['Image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Save the new image
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // Use existing image if no new image is uploaded
                $newFileName = $this->request->getPost('Image');
            }
            $updatedMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'ProductName' => $this->request->getPost('ProductName'),
                'ProductPrice' => $this->request->getPost('ProductPrice'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
            $updated = $this->products->update($productID, $updatedMenuData);
            if ($updated) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item updated successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to update menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function addCafeMenuIcedd()
    {
        helper(['form']);
        $validationRules = [
            
            'IcedName' => 'required',
            'PriceTall' => 'required',
            'PriceGrande' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('validationErrors', $validationErrors);
        }
        $inputCategoryName = 'Iced Coffee';
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
        if ($menuCategory && $menuCafe) {
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Please upload an image.');
            }
            $newMenuData = [
                'CategoryName' => $this->request->getPost('CategoryName'),
                'IcedName' => $this->request->getPost('IcedName'),
                'PriceTall' => $this->request->getPost('PriceTall'),
                'PriceGrande' => $this->request->getPost('PriceGrande'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
            $inserted = $this->iced->insert($newMenuData);
            if ($inserted) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item added successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to add menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
    public function deleteCafeMenuIcedd($icedID)
    {
        $iced = $this->iced->find($icedID);
        if ($iced) {
            $deleted = $this->iced->delete($icedID);
            if ($deleted) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item deleted successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to delete menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Menu item not found.');
        }
    }
    public function updateCafeMenuIcedd()
    {
        helper(['form']);
        $validationRules = [
            'IcedName' => 'required',
            'PriceTall' => 'required',
            'PriceGrande' => 'required',
            'Image' => 'uploaded[Image]|max_size[Image,10240]|ext_in[Image,png,jpg,gif]',
        ];
        if (!$this->validate($validationRules)) {
            $validationErrors = $this->validator->getErrors();
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('validationErrors', $validationErrors);
        }
        $productID = $this->request->getPost('IcedID'); 
        $inputCategoryName = 'Iced Coffee';
        $menuCategory = $this->categories->where('CategoryName', $inputCategoryName)->first();
        $inputCafeMenu = 'Cafe Menu';
        $menuCafe = $this->menus->where('MenuType', $inputCafeMenu)->first();
        if ($menuCategory && $menuCafe) {
            $newFileName = null;
            if ($image = $this->request->getFile('Image')) {
                if ($image->isValid() && !$image->hasMoved()) {
                    // Fetch the current product data
                    $currentProduct = $this->products->find($productID);
                    if ($currentProduct && !empty($currentProduct['Image'])) {
                        // Delete the old image
                        $oldFilePath = FCPATH . 'restaurant/' . $currentProduct['Image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Save the new image
                    $newFileName = $image->getRandomName();
                    $image->move(FCPATH . 'restaurant/', $newFileName);
                } else {
                    return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to upload image. Please try again.');
                }
            } else {
                // Use existing image if no new image is uploaded
                $newFileName = $this->request->getPost('Image');
            }
            $updatedMenuData = [
                'IcedName' => $this->request->getPost('IcedName'),
                'PriceTall' => $this->request->getPost('PriceTall'),
                'PriceGrande' => $this->request->getPost('PriceGrande'),
                'CategoryID' => $menuCategory['CategoryID'],
                'MenuID' => $menuCafe['MenuID'],
                'Image' => $newFileName
            ];
            $updated = $this->iced->update($productID, $updatedMenuData);
            if ($updated) {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('success', 'Menu item updated successfully.');
            } else {
                return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Failed to update menu item. Please try again.');
            }
        } else {
            return redirect()->to(base_url('/staff-restaurant-menu'))->with('error', 'Invalid category or main menu. Please check your input.');
        }
    }
}
