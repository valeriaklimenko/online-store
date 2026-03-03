<?php

namespace App\Enums;

enum Permissions: string
{
    case CAN_VIEW_PRODUCT = 'can_view_product';
    case CAN_VIEW_PRODUCTS = 'can_view_products';
    case CAN_CREATE_PRODUCT = 'can_create_product';
    case CAN_UPDATE_PRODUCT = 'can_update_product';
    case CAN_DELETE_PRODUCT = 'can_delete_product';

    case CAN_VIEW_CATEGORIES = 'can_view_categories';
    case CAN_CREATE_CATEGORY = 'can_create_category';
    case CAN_UPDATE_CATEGORY = 'can_update_category';
    case CAN_DELETE_CATEGORY = 'can_delete_category';

    case CAN_VIEW_MANAGERS = 'can_view_managers';
    case CAN_CREATE_MANAGER = 'can_create_manager';
    case CAN_DELETE_MANAGER = 'can_delete_manager';
    case CAN_VIEW_MANAGER_DASHBOARD = 'can_view_manager_dashboard';

    case CAN_VIEW_BASKET = 'can_view_basket';
    case CAN_ADD_TO_BASKET = 'can_add_to_basket';
    case CAN_REMOVE_FROM_BASKET = 'can_remove_from_basket';

    case CAN_VIEW_FAVORITES = 'can_view_favorites';
    case CAN_ADD_TO_FAVORITES = 'can_add_to_favorites';
    case CAN_REMOVE_FROM_FAVORITES = 'can_remove_from_favorites';

    case CAN_VIEW_PROFILE = 'can_view_profile';
    case CAN_UPDATE_PROFILE = 'can_update_profile';
    case CAN_CHANGE_PASSWORD = 'can_change_password';
    case CAN_CHANGE_EMAIL = 'can_change_email';

    case CAN_LOGIN = 'can_login';
    case CAN_LOGOUT = 'can_logout';
    case CAN_REGISTER = 'can_register';

    case CAN_VERIFY_EMAIL = 'can_verify_email';

    case CAN_VIEW_ORDERS = 'can_view_orders';
    case CAN_ORDER = 'can_order';
    case CAN_CHANGE_ORDER_STATUS = 'can_change_order_status';
    case CAN_VIEW_ORDERS_HISTORY = 'can_view_orders_history';

    case CAN_MANAGE_USERS = 'can_manage_users';

    case CAN_VIEW = 'can_view';

    case CAN_CREATE_ITEM = 'can_create';
    case CAN_UPDATE_ITEM = 'can_update';
    case CAN_DELETE_ITEM = 'can_delete';
    case CAN_ADD_IN_BASKET = 'can_add_in_basket';
    case CAN_MANAGER = 'can_manager';
    case CAN_ADD_IN_FAVORITE = 'can_add_in_favorite';
    case ADD_ITEM_AMOUNT = 'add_item_amount';
    case CHANGE_ORDERS_STATUS = 'can_change_orders_status';
    case CAN_WATCH_ORDERS_HISTORY = 'can_watch_orders_history';

    /**
     * Get all permissions as array of strings
     *
     * @return string[]
     */
    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get default permissions for regular users
     *
     * @return string[]
     */
    public static function defaultPermissions(): array
    {
        return [
            self::CAN_VIEW->value,
        ];
    }

    /**
     * Get permissions for admin role
     *
     * @return string[]
     */
    public static function adminPermissions(): array
    {
        return self::all();
    }

    /**
     * Get permissions for manager role
     *
     * @return string[]
     */
    public static function managerPermissions(): array
    {
        return [
            self::CAN_VIEW->value,
            self::CAN_VIEW_PRODUCT->value,
            self::CAN_VIEW_PRODUCTS->value,
            self::CAN_VIEW_CATEGORIES->value,

            self::CAN_CREATE_PRODUCT->value,
            self::CAN_UPDATE_PRODUCT->value,

            self::CAN_VIEW_ORDERS->value,
            self::CAN_CHANGE_ORDER_STATUS->value,

            self::CAN_VIEW_MANAGER_DASHBOARD->value,
            self::CAN_MANAGER->value,

            self::ADD_ITEM_AMOUNT->value,

            self::CAN_CREATE_ITEM->value,
            self::CAN_UPDATE_ITEM->value,
        ];
    }

    /**
     * Get permissions for user role
     *
     * @return string[]
     */
    public static function userPermissions(): array
    {
        return [

            self::CAN_VIEW->value,
            self::CAN_VIEW_PRODUCT->value,
            self::CAN_VIEW_PRODUCTS->value,

            self::CAN_VIEW_BASKET->value,
            self::CAN_ADD_TO_BASKET->value,
            self::CAN_REMOVE_FROM_BASKET->value,

            self::CAN_VIEW_FAVORITES->value,
            self::CAN_ADD_TO_FAVORITES->value,
            self::CAN_REMOVE_FROM_FAVORITES->value,

            self::CAN_VIEW_PROFILE->value,
            self::CAN_UPDATE_PROFILE->value,
            self::CAN_CHANGE_PASSWORD->value,
            self::CAN_CHANGE_EMAIL->value,

            self::CAN_ORDER->value,

            self::CAN_ADD_IN_BASKET->value,
            self::CAN_ADD_IN_FAVORITE->value,
        ];
    }

    /**
     * Get permissions for guest role
     *
     * @return string[]
     */
    public static function guestPermissions(): array
    {
        return [
            self::CAN_VIEW->value,
            self::CAN_VIEW_PRODUCT->value,
            self::CAN_VIEW_PRODUCTS->value,
            self::CAN_REGISTER->value,
            self::CAN_LOGIN->value,
        ];
    }
}
