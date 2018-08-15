<?php

return [
    'menu'       => [
        'dashboard'                => 'Thông báo',
        'admin_users'              => 'Quản trị viên',
        'users'                    => 'Nhười dùng',
        'admin_user_notifications' => 'AdminUserNotifications',
        'user_notifications'       => 'Thông báo người dùng',
        'site_configuration'       => 'Site Configuration',
        'log_system'               => 'Logs System',
        'images'                   => 'Ảnh',
        'articles'                 => 'Articles',
    ],
    'breadcrumb' => [
        'dashboard'                => 'Thông báo',
        'admin_users'              => 'Quản trị viên',
        'users'                    => 'Người dùng',
        'admin_user_notifications' => 'AdminUserNotifications',
        'user_notifications'       => 'Thông báo người dùng',
        'site_configuration'       => 'Site Configuration',
        'log_system'               => 'Logs',
        'images'                   => 'Ảnh',
        'articles'                 => 'Articles',
        'create_new'               => 'Tạo mới',
    ],
    'messages'   => [
        'general' => [
            'update_success' => 'Cập nhật thành công.',
            'create_success' => 'Tạo thành công.',
            'delete_success' => 'Xóa thành công.',
        ],
    ],
    'errors'     => [
        'general'  => [
            'save_failed' => 'Lưu thật bại. Liên hệ với nhà phát triển',
        ],
        'requests' => [
            'me' => [
                'email'    => [
                    'required' => 'Nhập Email',
                    'email'    => 'Email không hợp lệ',
                ],
                'password' => [
                    'min' => 'Mật khẩu có ít nhất 6 kí tự',
                ],
            ],
        ],
    ],
    'pages'      => [
        'common'                   => [
            'label'   => [
                'page'             => 'Trang',
                'actions'          => 'Hành Động',
                'is_enabled'       => 'Trạng thái',
                'is_enabled_true'  => 'Enabled',
                'is_enabled_false' => 'Disabled',
                'search_results'   => 'Total: :count results',
            ],
            'buttons' => [
                'create'          => 'Tạo mới',
                'edit'            => 'Sửa',
                'save'            => 'Lưu',
                'delete'          => 'Xóa',
                'cancel'          => 'Cancel',
                'back'            => 'Trở về',
                'add'             => 'Thêm',
                'preview'         => 'Xem trước',
                'forgot_password' => 'Gửi Mail cho tôi!',
                'reset_password'  => 'Reset Password',
            ],
        ],
        'auth'                     => [
            'buttons'  => [
                'sign_in'         => 'Đăng nhập',
                'forgot_password' => 'Gửi Mail cho tôi!',
                'reset_password'  => 'Reset Password',
            ],
            'messages' => [
                'remember_me'     => 'Remember Me',
                'please_sign_in'  => 'Sign in to start your session',
                'forgot_password' => 'Quên mật khẩu',
                'reset_password'  => 'Nhập địa chỉ mail và mật khẩu mới',
            ],
        ],
        'site-configurations'      => [
            'columns' => [
                'locale'                => 'Locale',
                'name'                  => 'Name',
                'title'                 => 'Title',
                'keywords'              => 'Keywords',
                'description'           => 'Descriptions',
                'ogp_image_id'          => 'OGP Image',
                'twitter_card_image_id' => 'Twitter Card Image',
            ],
        ],
        'articles'                 => [
            'columns' => [
                'slug'               => 'Slug',
                'title'              => 'Title',
                'keywords'           => 'Keywords',
                'description'        => 'Description',
                'content'            => 'Content',
                'cover_image_id'     => 'Cover Image',
                'locale'             => 'Locale',
                'is_enabled'         => 'Active',
                'publish_started_at' => 'Publish Started At',
                'publish_ended_at'   => 'Publish Ended At',
                'is_enabled_true'    => 'Enabled',
                'is_enabled_false'   => 'Disabled',

            ],
        ],
        'user-notifications'       => [
            'columns' => [
                'user_id'       => 'User',
                'category_type' => 'Category',
                'type'          => 'Type',
                'data'          => 'Data',
                'locale'        => 'Locale',
                'content'       => 'Content',
                'read'          => 'Read',
                'read_true'     => 'Read',
                'read_false'    => 'Unread',
                'sent_at'       => 'Sent At',
            ],
        ],
        'admin-user-notifications' => [
            'columns' => [
                'user_id'       => 'User',
                'category_type' => 'Category',
                'type'          => 'Type',
                'data'          => 'Data',
                'locale'        => 'Locale',
                'content'       => 'Content',
                'read'          => 'Read',
                'read_true'     => 'Read',
                'read_false'    => 'Unread',
                'sent_at'       => 'Sent At',
            ],
        ],
        'images'                   => [
            'columns' => [
                'url'                    => 'URL',
                'title'                  => 'Title',
                'is_local'               => 'is Local',
                'entity_type'            => 'EntityType',
                'entity_id'              => 'ID',
                'file_category_type'     => 'Category',
                's3_key'                 => 'S3 Key',
                's3_bucket'              => 'S3 Bucket',
                's3_region'              => 'S3 Region',
                's3_extension'           => 'S3 Extension',
                'media_type'             => 'Media Type',
                'format'                 => 'Format',
                'file_size'              => 'File Size',
                'width'                  => 'Width',
                'height'                 => 'Height',
                'has_alternative'        => 'has Alternative',
                'alternative_media_type' => 'Alternative Media Type',
                'alternative_format'     => 'Alternative Format',
                'alternative_extension'  => 'Alternative Extension',
                'is_enabled'             => 'Status',
                'is_enabled_true'        => 'Enabled',
                'is_enabled_false'       => 'Disabled',
            ],
        ],
        'admin-users'              => [
            'columns' => [
                'name'             => 'Name',
                'email'            => 'Email',
                'password'         => 'Password',
                're_password'      => 'Confirm Password',
                'role'             => 'Role',
                'locale'           => 'Locale',
                'profile_image_id' => 'Avatar',
                'permissions'      => 'Permissions',
            ],
        ],
        'users'                    => [
            'columns' => [
                'name'                 => 'Name',
                'email'                => 'Email',
                'password'             => 'Password',
                'gender'               => 'Gender',
                'gender_male'          => 'Male',
                'gender_female'        => 'Female',
                'telephone'            => 'Telephone',
                'birthday'             => 'Birthday',
                'locale'               => 'Locale',
                'address'              => 'Address',
                'remember_token'       => 'Remember Token',
                'api_access_token'     => 'Api Access Token',
                'profile_image_id'     => 'Profile Image',
                'last_notification_id' => 'Last Notification Id',
                'is_activated'         => 'is Activated',
            ],
        ],
        'logs'                     => [
            'columns' => [
                'user_name' => 'User Name',
                'email'     => 'Email',
                'action'    => 'Action',
                'table'     => 'Table',
                'record_id' => 'Record ID',
                'query'     => 'Query',
            ],
        ],
        'oauth-clients'            => [
            'columns' => [
                'user_id'                => 'User ID',
                'name'                   => 'Name',
                'secret'                 => 'Secret',
                'redirect'               => 'Redirect',
                'personal_access_client' => 'Personal Access Client',
                'password_client'        => 'Password Client',
                'revoked'                => 'Revoked',
            ],
        ],
        /* NEW PAGE STRINGS */
    ],
    'roles'      => [
        'admin'            => 'Administrator',
        'coach'            => 'Huấn Luyện Viên',
        'player'           => 'Người chơi',
    ],
];
