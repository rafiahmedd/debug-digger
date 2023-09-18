<?php
add_action('admin_menu', [new DebugDigger\App\Services\AdminMenuService, 'addMenu']);