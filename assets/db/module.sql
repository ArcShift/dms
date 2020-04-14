INSERT INTO `module` (`id`, `name`, `title`, `on_menu`, `icon`, `parent`) VALUES
(4, 'account', 'Akun', 'NO', 'user', NULL),
(5, 'dashboard', 'Dashboard', 'YES', 'home', NULL),
(6, 'company', 'Perusahaan', 'YES', 'building', 'user_management'),
(7, 'unit_kerja', 'Unit Kerja', 'YES', 'id-badge', 'user_management'),
(8, 'user', 'Akun', 'YES', 'users', 'user_management'),
(9, 'standard', 'Daftar Standar', 'YES', 'list-alt', 'standard'),
(10, 'company_standard', 'Standar Perusahaan', 'YES', 'list-ul', 'standard'),
(12, 'treeview_detail', 'Manajemen Standar Perusahaan', 'YES', 'braille', 'user_data'),
(100, 'role', NULL, 'NO', 'universal-access', NULL);