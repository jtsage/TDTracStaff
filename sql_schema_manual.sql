-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 17, 2019 at 02:07 PM
-- Server version: 5.7.27-0ubuntu0.18.04.1-log
-- PHP Version: 7.2.24-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `tdtracx_staff`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_configs`
--

CREATE TABLE `app_configs` (
  `id` char(36) NOT NULL,
  `key_name` varchar(50) NOT NULL,
  `value_short` varchar(250) DEFAULT NULL,
  `value_long` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_configs`
--

INSERT INTO `app_configs` (`id`, `key_name`, `value_short`, `value_long`) VALUES
('07ed25e3-240c-4ca2-ab4b-4a45f142c2b3', 'server-name', 'FQDN, with protocal of the server name', 'https://demostaff.tdtrac.com'),
('1066f6f6-bb33-430f-9e08-561e33d7d6f8', 'job-new-email', 'Sent when a job is newly added to the database and needs staff to indicate availability', 'Good day!\\n\\nYou are receiving the e-mail due to the fact that a new job has been added to {{long-name}}\'s TDTracStaff instance.  Job staffing requirements have been added, and based on your training profile, you qualify for one or more of the open positions.  Please follow the link below to indicate your availability as soon as possible.  You will be notified if you are selected to be scheduled for this job.\\n\\n * __Job Name__: [[name]]\\n * __Job Description__: [[detail]]\\n * __Job Location__: [[location]]\\n\\nThis job runs from _[[date_start_string]]_ through _[[date_end_string]]_.  The time(s) of the event are _[[time_string]]_.  If scheduled, payroll hours will be due no later than _[[due_payroll_submitted_string]]_, with paychecks cut on _[[due_payroll_paid_string]]_.\\n\\n<div>\\n@@@{{server-name}}/jobs/available/[[id]]|Set your availability@@@\\n</div>\\n\\nThank you for your time today!\\n\\n_~{{admin-name}}_\\n<{{admin-email}}>'),
('11782b20-8c91-4f83-bd45-2feef5c8fdf2', 'job-old-email', 'Sent when a job is NOT newly added to the database and either STILL needs staff to indicate availability, or staffing needs have changed', 'Good day!\\n\\nYou are receiving the e-mail due to the fact that a job that has been added to {{long-name}}\'s TDTracStaff instance still requires staffing, or the staffing requirements have recently changed. Based on your training profile, you qualify for one or more of the open positions. Please follow the link below to indicate your availability as soon as possible. Our apologies if you have already indicated your availability, this is a limitation of the current system. You will be notified if you are selected to be scheduled for this job.\\n\\n* __Job Name__: [[name]]\\n* __Job Description__: [[detail]]\\n* __Job Location__: [[location]]\\n\\nThis job runs from _[[date_start_string]]_ through _[[date_end_string]]_. The time(s) of the event are _[[time_string]]_. If scheduled, payroll hours will be due no later than _[[due_payroll_submitted_string]]_, with paychecks cut on _[[due_payroll_paid_string]]_.\\n\\n<div>\\n@@@{{server-name}}/jobs/available/[[id]]|Set your availability@@@\\n</div>\\n\\nThank you for your time today!\\n\\n_~{{admin-name}}_\\n<{{admin-email}}>'),
('21873149-f8d7-4bb7-9192-ad212ff1be5e', 'welcome-email', 'The welcome E-Mail', 'Good day!\n\nWelcome to {{long-name}}\'s digital time sheet and staffing system.  The e-mail below contains your temporary password, username, and login link.\n\nYou have been assigned a temporary password, please change it the first time you log in!\n\nAddress:  {{server-name}}\nUsername: {{username}}\nPassword: {{password}}\n\n@@@{{server-name}}/books/quickstart.pdf|Quick Start Guide@@@\n\n@@@{{server-name}}/books/handbook.pdf|Handbook@@@\n\nThanks,\n\n{{admin-name}}\n{{admin-email}}'),
('46596a40-576d-4319-803e-cdb3a880dbfd', 'require-hours', 'Require hours worked, rather than just a total - must be 0 (use a total), or 1 (use start and end times)', '1'),
('67dc9387-52bd-4ced-a377-957f0b043617', 'notify-email', 'Email sent when you have scheduled 1 or more staff members.', 'Good day!\\n\\nYou are receiving the e-mail due to the fact that a job has been staffed in {{long-name}}\'s TDTracStaff instance. Please visit the link below to check if you have been selected to be scheduled for this job.\\n\\n* __Job Name__: [[name]]\\n* __Job Description__: [[detail]]\\n* __Job Location__: [[location]]\\n\\nThis job runs from _[[date_start_string]]_ through _[[date_end_string]]_. The time(s) of the event are _[[time_string]]_. If scheduled, payroll hours will be due no later than _[[due_payroll_submitted_string]]_, with paychecks cut on _[[due_payroll_paid_string]]_.\\n\\n<div>\\n@@@{{server-name}}/jobs/view/[[id]]|View your schedule@@@\\n</div>\\n\\nThank you for your time today!\\n\\n_~{{admin-name}}_\\n<{{admin-email}}>'),
('7aebba45-57b5-4a5e-a788-004f4ffb043c', 'paydates-period', 'Set of period paydate, in the format [ \"2019-09-11\", 14 ] (start, period) or false', 'false'),
('8b37c74a-3973-4864-bf96-3ec0059967c1', 'admin-name', 'The administrator\'s Name', 'Example Admin'),
('9d0a4cdf-91db-4079-ad20-b350a51424cd', 'long-name', 'Long name of the system, usually a company name', 'Example Company'),
('bbb58578-7411-4aa6-a3e0-aeb1acc0fe54', 'calendar-api-key', 'Key for iCal (ics) access - probably a UUID or hash or password - that is sent in cleartext.', '5f1742c5-441e-4575-beff-c32a33ea7aa7'),
('cec8b70f-a89a-42d0-9940-2f2d58102f5f', 'mailing-address', 'Mailing Address of the company - used in E-Mails.', '123 Fake Street, Pittsburgh, PA 15201'),
('dca46886-6cf7-41b7-8e9e-a1c350a0c79f', 'paydates-fixed', 'Set of fixed paydate, in the fixed format: [ [-1,-1,15], [-1,-1,30] ] (15th and 30th) or false', '[ [-1,-1,15], [-1,-1,30] ]'),
('e79b33e7-5cad-4171-bc84-83cad71a0d0e', 'admin-email', 'The administrator\'s E-Mail Address', 'jtsage@gmail.com'),
('fc43931f-37b7-459c-8cc0-dd362e3b2ae5', 'allow-unscheduled-hours', 'Allow adding hours to jobs the user is not scheduled for. (0 /1)', '1'),
('fe35a641-5ce3-47f6-90fe-14dca4cdb0ab', 'short-name', 'Short name of the Site, usually Initials', 'EC'),
('76b14e8d-00fd-4890-832a-540a49e2960f', 'time-zone', 'Display Time Zone - Used infrequently, data is stored without modification.', 'America/New_York'),
('c9e14a00-416b-498a-8464-78d700780a14', 'queue-email', 'Queue E-Mail for sending later. This is a good idea, but requires cron setup to be complete.', '1');

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `id` char(36) NOT NULL,
  `vendor` varchar(150) NOT NULL,
  `category` varchar(150) NOT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `user_id` char(36) NOT NULL,
  `job_id` char(36) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` char(36) NOT NULL,
  `name` varchar(60) NOT NULL,
  `detail` varchar(60) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `time_string` varchar(250) NOT NULL,
  `due_payroll_submitted` date DEFAULT NULL,
  `due_payroll_paid` date DEFAULT NULL,
  `notes` text,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_open` tinyint(1) NOT NULL DEFAULT '1',
  `has_payroll` tinyint(1) NOT NULL DEFAULT '1',
  `has_budget` tinyint(1) NOT NULL DEFAULT '0',
  `has_budget_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '1970-01-01 10:00:01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobs_roles`
--

CREATE TABLE `jobs_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `job_id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  `number_needed` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `id` char(36) NOT NULL,
  `date_worked` date NOT NULL,
  `time_start` time NOT NULL DEFAULT '08:00:00',
  `time_end` time NOT NULL DEFAULT '17:00:00',
  `hours_worked` float(4,2) DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `user_id` char(36) NOT NULL,
  `job_id` char(36) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '1970-01-01 10:00:01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` char(36) NOT NULL,
  `title` varchar(100) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '999',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '1970-01-01 10:00:01'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first` varchar(50) NOT NULL,
  `last` varchar(50) NOT NULL,
  `phone` varchar(13) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_password_expired` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_budget` tinyint(1) NOT NULL DEFAULT '0',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `last_login_at` timestamp NOT NULL DEFAULT '1970-01-01 15:00:01',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '1970-01-01 15:00:01',
  `reset_hash` varchar(60) DEFAULT NULL,
  `reset_hash_time` timestamp NOT NULL DEFAULT '1970-01-01 15:00:01',
  `verify_hash` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_jobs`
--

CREATE TABLE `users_jobs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` char(36) NOT NULL,
  `job_id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT '0',
  `is_scheduled` tinyint(1) NOT NULL DEFAULT '0',
  `note` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE `users_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` char(36) NOT NULL,
  `role_id` char(36) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_configs`
--
ALTER TABLE `app_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_roles`
--
ALTER TABLE `jobs_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `phinxlog`
--
ALTER TABLE `phinxlog`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `reset_hash` (`reset_hash`);

--
-- Indexes for table `users_jobs`
--
ALTER TABLE `users_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `job_id` (`job_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobs_roles`
--
ALTER TABLE `jobs_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_jobs`
--
ALTER TABLE `users_jobs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_roles`
--
ALTER TABLE `users_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `budgets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jobs_roles`
--
ALTER TABLE `jobs_roles`
  ADD CONSTRAINT `jobs_roles_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `jobs_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD CONSTRAINT `payrolls_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payrolls_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_jobs`
--
ALTER TABLE `users_jobs`
  ADD CONSTRAINT `users_jobs_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_jobs_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_jobs_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `users_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_roles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;
