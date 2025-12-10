<?php

namespace App\Enums;

enum Permissions: string
{
    case CAN_ACCESS = 'can_access';
    case CAN_CREATE_ITEM = 'can_create';
    case CAN_UPDATE_ITEM = 'can_update';
    case CAN_DELETE_ITEM = 'can_delete';
    case CAN_ADD_IN_BASKET = 'can_add_in_basket';
    case CAN_MANAGER = 'can_manager';
    case CAN_VIEW = 'can_view';
    case CAN_ORDER = 'can_order';
    case CAN_ADD_IN_FAVORITE = 'can_add_in_favorite';
    case CAN_CREATE_CATEGORY = 'can_create_category';
    case CAN_UPDATE_CATEGORY = 'can_update_category';
    case CAN_DELETE_CATEGORY = 'can_delete_category';
    case ADD_ITEM_AMOUNT = 'add_item_amount';
    case CAN_VIEW_ORDERS = 'can_view_orders';
    case CHANGE_ORDERS_STATUS = 'can_change_orders_status';
    case CAN_MANAGE_USERS = 'can_manage_users';
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
            self::CAN_VIEW->value
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
            self::CAN_CREATE_ITEM->value,
            self::CAN_UPDATE_ITEM->value,
            self::CAN_ACCESS->value,
            self::CAN_CREATE_CATEGORY->value,
            self::CAN_UPDATE_CATEGORY->value,
            self::ADD_ITEM_AMOUNT->value,
            self::CAN_VIEW_ORDERS->value,
            self::CHANGE_ORDERS_STATUS->value,
            self::CAN_MANAGER->value,
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
        ];
    }
}
