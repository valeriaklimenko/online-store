<?php

namespace App\Enums;

enum FlashMessage: string
{
    case PRODUCT_CREATED = 'Product created successfully.';
    case PRODUCT_UPDATED = 'Product updated successfully';
    case PRODUCT_DELETED = 'The product was successfully deleted';

    case CATEGORY_CREATED = 'Category created successfully';
    case CATEGORY_UPDATED = 'Category updated successfully';
    case CATEGORY_DELETED = 'Category deleted successfully';

    case FAVORITES_ADDED = 'Item was successfully added to favorites';
    case FAVORITES_REMOVED = 'Item was successfully removed from favorites';

    case BASKET_ADDED = 'Item was successfully added to basket!';
    case BASKET_REMOVED = 'Item was successfully removed from basket';
    case BASKET_NOT_ENOUGH_STOCK = 'Not enough stock for this product';

    case MANAGER_CREATED = 'Manager created successfully';
    case MANAGER_DELETED = 'The manager was successfully deleted';

    case EMAIL_CHANGE_PENDING = 'A verification email has been sent to your new email address. Please check your inbox.';
    case ACCOUNT_UPDATED = 'Profile successfully updated!';
    case PASSWORD_UPDATED = 'Password successfully updated!';
    case EMAIL_CHANGED = 'Email changed successfully!';

    case LINK_ERROR = 'Invalid verification link.';
    case LINK_SENT = 'Verification link sent.';
    case PROFILE_ERROR = 'An error has occurred!';

    case LOGIN_FAILED = 'Credentials are not correct.';
    case LOGOUT_SUCCESSFUL = 'You have been logged out successfully.';
    case DELETE_ACCOUNT_FAILED = 'An error occurred while deleting your account. Please try again.';
    case DELETE_ACCOUNT_SUCCESSFUL = 'Your account was successfully deleted.';
}
