-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 04:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tour_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `description`, `created_at`, `updated_at`) VALUES
(1, '<h4><strong>T</strong>our <strong>M</strong>anagement <strong>S</strong>ystem by<i> <strong>Baseline IT Development</strong></i></h4><p>A tour management system by BaselineIT Development optimizes the planning, booking, and management of tours and travel services. Key features include:</p><ol><li><strong>Booking Management</strong>: This feature encompasses a comprehensive system for handling customer reservations and inquiries. It includes functionalities such as real-time availability checks, automated confirmation emails, and a centralized dashboard for managing bookings. This ensures that agents can efficiently schedule tours, manage capacities, and prevent overbooking, thereby optimizing resource utilization.</li><li><strong>Itinerary Planning</strong>: Agents can create customized travel itineraries tailored to individual client preferences and requirements. This feature allows for flexibility in designing unique travel experiences, incorporating specific destinations, activities, and accommodations. It supports collaborative planning between agents and clients, enabling seamless adjustments and updates to itineraries as needed.</li><li><strong>Inventory Control</strong>: Centralized management of inventory including accommodations (hotels, resorts, vacation rentals), transportation (flights, trains, buses), and activities (tours, excursions, attractions). The system tracks availability in real-time, manages allocations, and updates availability status across all channels. This prevents double bookings, ensures accurate inventory management, and enhances operational efficiency.</li><li><strong>Payment Integration</strong>: Integration with secure payment gateways facilitates smooth and convenient payment processing for customers. The system supports various payment methods (credit/debit cards, online banking, digital wallets), ensuring flexibility and security in transactions. Automated invoicing and receipt generation streamline financial processes, providing transparency and ease of payment for clients.</li><li><strong>Reporting and Analytics</strong>: Robust reporting tools generate comprehensive insights into business performance metrics such as sales trends, booking patterns, revenue generation, and customer demographics. Customizable dashboards and analytics enable data-driven decision-making, helping tour operators identify opportunities for growth, optimize marketing strategies, and improve operational efficiency.</li><li><strong>Customer Relationship Management (CRM)</strong>: CRM functionalities enhance client relationship management through personalized communication, customer profiles, and interaction histories. Agents can track client preferences, manage inquiries and feedback, and nurture customer loyalty through targeted marketing campaigns and loyalty programs. This fosters long-term relationships, increases customer satisfaction, and encourages repeat bookings.</li><li><strong>Mobile Access</strong>: Mobile-friendly interfaces enable agents and customers to access the system anytime, anywhere. Mobile apps or responsive web interfaces provide flexibility for managing bookings, accessing itineraries, and receiving real-time updates on travel arrangements. This accessibility enhances user convenience, responsiveness to last-minute changes, and overall customer satisfaction.</li><li><strong>Automated Notifications</strong>: Automated alerts and notifications keep clients informed about booking confirmations, payment reminders, itinerary updates, and travel advisories. This proactive communication reduces manual workload, minimizes communication gaps, and ensures timely and relevant information delivery. This feature contributes to a seamless and stress-free travel experience for customers.</li><li><strong>Multi-language Support</strong>: Multilingual capabilities cater to a diverse global clientele by offering interfaces and communications in multiple languages. Language preferences can be set based on customer profiles, ensuring clear and effective communication throughout the booking and travel process. This enhances accessibility, improves customer engagement, and supports international expansion strategies.</li><li><strong>Third-Party Integrations</strong>: Seamless integration with third-party software systems such as accounting software, CRM platforms, marketing tools, and channel management systems. This interoperability streamlines data exchange, automates workflows, and creates a cohesive operational ecosystem. Integration with external APIs (Application Programming Interfaces) facilitates data synchronization, enhances efficiency, and supports scalability as business needs evolve.</li></ol><p>These advanced features collectively empower tour operators to streamline operations, deliver exceptional customer experiences, and achieve sustainable growth in the competitive travel and tourism industry.</p>', '2024-06-24 10:53:18', '2024-06-24 10:53:18');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `cart_id` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `user_id`, `cart_id`, `first_name`, `last_name`, `country`, `city`, `state`, `zip_code`, `email`, `phone`, `status`, `created_at`, `updated_at`) VALUES
(133, 'sagar@gmail.com', '101', 'Sagar', 'Joshi', 'India', 'Patiala', 'Punjab', '147001', 'sagar@gmail.com', '7888765928', 'approved', '2024-06-24 08:05:34', '2024-06-24 08:05:34'),
(134, 'sagar@gmail.com', '102', 'Sagar', 'Joshi', 'India', 'Patiala', 'Punjab', '147001', 'sagar@gmail.com', '7888765928', 'approved', '2024-06-24 08:08:54', '2024-06-24 08:08:54'),
(135, 'test@gmail.com', '103', 'Test', 'T', 'India', 'Mohali', 'Punjab', '140055', 'test@gmail.com', '7889457845', 'approved', '2024-06-24 09:18:55', '2024-06-24 09:18:55'),
(136, 'test@gmail.com', '104', 'Test', 'test', 'India', 'Mohali', 'Punjab', '140055', 'test@gmail.com', '7889457845', 'approved', '2024-06-24 09:23:31', '2024-06-24 09:23:31'),
(137, 'test@gmail.com', '105', 'Jhonny', 'calves', 'Canada', 'Calgary', 'Manitoba', '111221', 'Johnnycalves123@gmail.com', '1234567890', 'approved', '2024-06-25 10:15:02', '2024-06-25 10:15:02'),
(138, 'sagar@gmail.com', '106', 'Sagar', 'Joshi', 'India', 'Patiala', 'Punjab', '147001', 'sagar@gmail.com', '7888765928', 'approved', '2024-06-26 02:22:57', '2024-06-26 02:22:57'),
(139, 'sagar@gmail.com', '107', 'Sagar', 'Joshi', 'India', 'Patiala', 'Punjab', '147001', 'sagar@gmail.com', '7888765928', 'approved', '2024-06-26 07:05:08', '2024-06-26 07:05:08'),
(140, 'test@gmail.com', '108', 'Test', 'T', 'India', 'Mohali', 'Punjab', '140055', 'test@gmail.com', '7889457845', 'approved', '2024-06-26 10:19:08', '2024-06-26 10:19:08'),
(142, 'test@gmail.com', '109', 'Test', 'T', 'India', 'Mohali', 'Punjab', '140055', 'test@gmail.com', '7889457845', 'approved', '2024-06-28 06:32:19', '2024-06-28 06:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `package_id` varchar(100) NOT NULL,
  `from_date` datetime NOT NULL,
  `to_date` datetime NOT NULL,
  `status` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `package_id`, `from_date`, `to_date`, `status`, `quantity`, `created_at`, `updated_at`) VALUES
(101, 'sagar@gmail.com', '9', '2024-06-24 13:33:01', '2024-07-01 13:33:01', 'approved', '2', '2024-06-24 08:03:01', '2024-06-24 08:03:01'),
(102, 'sagar@gmail.com', '3', '2024-07-22 13:36:42', '2024-07-26 13:36:42', 'approved', '2', '2024-06-24 08:06:42', '2024-06-24 08:06:42'),
(103, 'test@gmail.com', '1', '2024-06-24 14:32:02', '2024-07-01 14:32:02', 'approved', '1', '2024-06-24 09:02:02', '2024-06-24 09:02:02'),
(104, 'test@gmail.com', '2', '2024-07-01 14:52:37', '2024-07-08 14:52:37', 'approved', '1', '2024-06-24 09:22:37', '2024-06-24 09:22:37'),
(105, 'test@gmail.com', '1', '2024-06-26 15:40:59', '2024-06-27 15:40:59', 'approved', '1', '2024-06-25 10:10:59', '2024-06-25 10:10:59'),
(106, 'sagar@gmail.com', '2', '2024-06-26 07:52:03', '2024-07-01 07:52:03', 'approved', '1', '2024-06-26 02:22:03', '2024-06-26 02:22:03'),
(107, 'sagar@gmail.com', '1', '2024-06-26 08:17:26', '2024-07-03 08:17:26', 'approved', '1', '2024-06-26 02:47:26', '2024-06-26 02:47:26'),
(108, 'test@gmail.com', '9', '2024-06-26 15:41:46', '2024-07-03 15:41:46', 'approved', '2', '2024-06-26 10:11:46', '2024-06-26 10:11:46'),
(109, 'test@gmail.com', '9', '2024-06-28 12:00:47', '2024-07-01 12:00:47', 'approved', '2', '2024-06-28 06:30:47', '2024-06-28 06:30:47');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `description`, `created_at`, `updated_at`) VALUES
(1, '<p>We\'d love to hear from you! Whether you have questions about our tours, need assistance with bookings, or have any other inquiries, our team is here to help.&nbsp;</p><p><strong>BaselineIT Development</strong><br>1st Floor, F-33, Phase-8, Industrial Area, Sector 73, Sahibzada Ajit Singh Nagar, Punjab 160071</p><ul><li>E-Mail: <a href=\"mailto:hr@baselineitdevelopment.com\">hr@baselineitdevelopment.com</a></li><li>E-Mail: <a href=\"mailto:sales@baselineitdevelopment.com\">sales@baselineitdevelopment.com</a></li></ul><h4>Follow Us</h4><p>Stay updated with our latest news and offers by following us on social media.</p><ul><li><strong>Facebook</strong>: <a href=\"https://www.facebook.com/BaselineItDevelopment.pvt.ltd\">facebook.com/baselineitdev</a></li><li><strong>Twitter</strong>: <a href=\"https://x.com/BaselineITDev/\">twitter.com/baselineitdev</a></li><li><strong>Instagram</strong>: <a href=\"https://www.instagram.com/baseline.it.development/\">instagram.com/baselineitdev</a></li><li><strong>LinkedIn</strong>: <a href=\"https://in.linkedin.com/company/baselineitdevelopment\">linkedin.com/baselineitdev</a></li></ul>', '2024-06-25 02:20:33', '2024-06-25 02:20:33');

-- --------------------------------------------------------

--
-- Table structure for table `customer_form`
--

CREATE TABLE `customer_form` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `dob` varchar(100) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `con_password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_form`
--

INSERT INTO `customer_form` (`id`, `first_name`, `last_name`, `dob`, `gender`, `email`, `password`, `phone`, `con_password`, `role`, `created_at`, `updated_at`) VALUES
(17, 'Admin', 'Basline', '15-09-1998', 'Male', 'Admin@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '9876543210', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', '2024-06-07 04:34:09', '2024-06-07 04:34:09'),
(31, 'Sagar', 'Joshi', '2001-07-24', 'Male', 'sagar@gmail.com', 'cf299ba19ce28e89a055d8db3e5578a0', '7888765928', 'cf299ba19ce28e89a055d8db3e5578a0', 'customer', '2024-06-13 02:41:17', '2024-06-13 02:41:17'),
(34, 'Test', 'test', '2001-03-20', 'Male', 'test@gmail.com', 'f925916e2754e5e03f75dd58a5733251', '9876543210', 'f925916e2754e5e03f75dd58a5733251', 'customer', '2024-06-13 05:27:54', '2024-06-13 05:27:54'),
(35, 'Gagandeep', 'Deep', '1998-09-15', 'Male', 'gagandeepattri8@gmail.com', 'ce34a164455404b14b2c95d7c1ca8a82', '1234567890', 'ce34a164455404b14b2c95d7c1ca8a82', 'customer', '2024-06-13 10:02:14', '2024-06-13 10:02:14');

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

CREATE TABLE `enquiry` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `package_id` varchar(100) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `note` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enquiry`
--

INSERT INTO `enquiry` (`id`, `user_id`, `package_id`, `package_name`, `price`, `note`, `created_at`, `updated_at`) VALUES
(6, 'test@gmail.com', '1', 'Leh-Palace', '499', '[{\"type\":\"customer\",\"note\":\"Hii\"},{\"type\":\"admin\",\"note\":\"Good morning, how can i help u?\"},{\"type\":\"customer\",\"note\":\"I have enquiry on the package name Leh-Place the image did not match the location??\"},{\"type\":\"customer\",\"note\":\"Did not matched ?\"},{\"type\":\"admin\",\"note\":\"The image which is uploaded on the package (name Leh-Palace) is old.\\r\\nWe apologize for the misunderstanding. Try to upload the latest image of packages as soon as possible.\\r\\nThank You\"}]', '2024-06-27 07:33:45', '2024-06-27 07:33:45'),
(7, 'sagar@gmail.com', '1', 'Leh-Palace', '499', '[{\"type\":\"customer\",\"note\":\"Good morning Sir/Mam.\"},{\"type\":\"admin\",\"note\":\"Good morning, How can i help u?\"},{\"type\":\"customer\",\"note\":\"I pay the package payment but did not get any information for approval?\"},{\"type\":\"customer\",\"note\":\"Hello my name is gagandeep\"},{\"type\":\"admin\",\"note\":\"Hello Gagandeep, how can i help u ?\"},{\"type\":\"customer\",\"note\":\"How r u?\"}]', '2024-06-27 08:10:45', '2024-06-27 08:10:45'),
(8, 'sagar@gmail.com', '3', 'Jhakoo Hill', '299', '[{\"type\":\"customer\",\"note\":\"Hi is someone there ?\"},{\"type\":\"admin\",\"note\":\"Yes. Please let me know about your concern\"},{\"type\":\"customer\",\"note\":\"Is there anything for me ?\"},{\"type\":\"admin\",\"note\":\"yes nothig special\"},{\"type\":\"admin\",\"note\":\"Okay. Have a great day.\"}]', '2024-06-27 10:44:18', '2024-06-27 10:44:18'),
(9, 'test@gmail.com', '3', 'Jhakoo Hill', '299', '[{\"type\":\"customer\",\"note\":\"Hey \"},{\"type\":\"admin\",\"note\":\"What your name ?\"},{\"type\":\"admin\",\"note\":\"hy\"},{\"type\":\"customer\",\"note\":\"hello\"}]', '2024-06-27 10:47:22', '2024-06-27 10:47:22'),
(10, 'test@gmail.com', '9', 'Lakshman Jhula', '199', '[{\"type\":\"customer\",\"note\":\"Hello\"},{\"type\":\"admin\",\"note\":\"Yes, What is your concern\"},{\"type\":\"customer\",\"note\":\"nothing\"}]', '2024-06-27 10:50:25', '2024-06-27 10:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `id` int(11) NOT NULL,
  `package_name` varchar(100) NOT NULL,
  `place_name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`id`, `package_name`, `place_name`, `image`, `price`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Leh-Palace', 'Leh', 'uploads/pic0.jpg', '499', 'Its facade resembles that of the Potala Palace in Lhasa, the capital of Tibet. Leh Palace\'s roof offers amazing views of the Ladakh region and the Stok Kangri. With huge walls and wooden balconies, it is a great example of medieval Tibetan architecture and boasts nine storeys.', '2024-06-10 04:16:37', '2024-06-10 04:16:37'),
(2, 'Manikaran Hot Springs', 'Kasol', 'uploads/pic1.jpg', '399', 'Believed to have healing and curative properties, the Manikaran Hot Springs alongside the Gurudwara Shri Manikaran Sahib is visited by many pilgrims who come to bathe here.', '2024-06-10 04:21:13', '2024-06-10 04:21:13'),
(3, 'Jhakoo Hill', 'Shimla', 'uploads/pic2.jpg', '299', 'Perched on the tallest hill in Shimla, this spot is popular for its religious significance, scenic views, and memorable sunrises and sunsets.', '2024-06-10 04:24:05', '2024-06-10 04:24:05'),
(9, 'Lakshman Jhula', 'Rishikesh', 'uploads/pic3.jpg', '199', 'Built in 1939, over River Ganga, the jhula is one of the most prominent landmarks in Rishikesh. As the legend goes, Lord Lakshmana (Laxman) crossed Ganga on ropes of jute and hence the bridge has been named in his honour.', '2024-06-13 03:02:01', '2024-06-13 03:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`id`, `description`, `created_at`, `updated_at`) VALUES
(1, '<p>Last Updated: November 7, 2023</p><p><strong>Introduction</strong></p><p>BaselineIT Development (\"we\", \"us\", or \"our\") operates the Tour Management System (\"Service\"). This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you use our Service. By using our Service, you agree to the collection and use of information in accordance with this policy.</p><p><strong>Information We Collect</strong></p><ul><li><strong>Personal Information</strong>: When you register for our Service, we may collect personal information such as your name, email address, phone number, payment information, and other details necessary to provide our services.</li><li><strong>Usage Data</strong>: We automatically collect information about how you access and use the Service, including your IP address, browser type, access times, and pages viewed.</li><li><strong>Cookies and Tracking Technologies</strong>: We use cookies and similar tracking technologies to monitor the activity on our Service and hold certain information.</li></ul><p><strong>How We Use Your Information</strong></p><ul><li><strong>Service Delivery</strong>: We use the information we collect to provide, operate, and maintain our Service.</li><li><strong>Communication</strong>: We may use your information to contact you with newsletters, marketing or promotional materials, and other information that may be of interest to you.</li><li><strong>Improvement of Services</strong>: We use data analytics to improve our Service and enhance user experience.</li></ul><p><strong>Information Sharing and Disclosure</strong></p><ul><li><strong>Third-Party Service Providers</strong>: We may share your information with third-party service providers who perform services on our behalf, such as payment processing, data analysis, email delivery, and marketing services.</li><li><strong>Legal Requirements</strong>: We may disclose your information if required to do so by law or in response to valid requests by public authorities.</li></ul><p><strong>Data Security</strong></p><p>We implement a variety of security measures to maintain the safety of your personal information. However, no method of transmission over the Internet or method of electronic storage is 100% secure, and we cannot guarantee its absolute security.</p><p><strong>User Rights and Choices</strong></p><ul><li><strong>Access and Correction</strong>: You have the right to access and update your personal information.</li><li><strong>Data Deletion</strong>: You may request the deletion of your personal information, subject to certain legal obligations.</li><li><strong>Opt-Out Options</strong>: You can opt-out of receiving marketing communications from us at any time by following the unsubscribe link in our emails.</li></ul><p><strong>Changes to This Privacy Policy</strong></p><p>We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page.</p><p><strong>Contact Us</strong></p><p>If you have any questions about this Privacy Policy, please contact us: <a href=\"http://localhost/Sagar/contact_us.php\">Contact Us</a></p>', '2024-06-25 08:34:11', '2024-06-25 08:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `bill_id` varchar(100) NOT NULL,
  `selected_method` varchar(100) NOT NULL,
  `method_of_pay` varchar(100) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `card_number` varchar(100) NOT NULL,
  `expiry_date` varchar(100) NOT NULL,
  `cvc` varchar(100) NOT NULL,
  `cardholder_name` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `total_payment` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `bill_id`, `selected_method`, `method_of_pay`, `brand`, `transaction_id`, `email`, `card_number`, `expiry_date`, `cvc`, `cardholder_name`, `country`, `total_payment`, `currency`, `created_at`, `updated_at`) VALUES
(49, 'sagar@gmail.com', '133', 'Stripe', 'Card', 'visa', 'pm_1PV7tzFR1i2uVQl6dz6M98zF', 'sagar@gmail.com', '4242', '6/2025', 'pass', 'Sagar J', 'US', '798', 'usd', '2024-06-24 08:05:34', '2024-06-24 08:05:34'),
(50, 'sagar@gmail.com', '134', 'PayPal', 'Card', 'PayPal', '2VL26063HN756364X', 'sb-dzv7c30530472@personal.example.com', 'ZWGC', 'N/A', 'pass', 'Test T', 'India', '898', 'USD', '2024-06-24 08:08:54', '2024-06-24 08:08:54'),
(51, 'test@gmail.com', '135', 'Stripe', 'Card', 'visa', 'pm_1PV92zFR1i2uVQl6DCN4Kliq', 'test@gmail.com', '4242', '12/2028', 'pass', 'Test T', 'US', '899', 'usd', '2024-06-24 09:18:55', '2024-06-24 09:18:55'),
(52, 'test@gmail.com', '136', 'PayPal', 'Card', 'PayPal', '5NS18738V62107835', 'sb-dzv7c30530472@personal.example.com', 'ZWGC', 'N/A', 'pass', 'Test T', 'India', '499', 'USD', '2024-06-24 09:23:31', '2024-06-24 09:23:31'),
(53, 'test@gmail.com', '137', 'Stripe', 'Card', 'visa', 'pm_1PVWOqFR1i2uVQl6myI90sb0', 'Johnnycalves123@gmail.com', '4242', '12/2028', 'pass', 'Test T', 'US', '499', 'usd', '2024-06-25 10:15:03', '2024-06-25 10:15:03'),
(54, 'sagar@gmail.com', '138', 'Stripe', 'Card', 'visa', 'pm_1PVlVYFR1i2uVQl6Bxi2AkxD', 'sagar@gmail.com', '4242', '6/2025', 'pass', 'Sagar J', 'US', '399', 'usd', '2024-06-26 02:22:58', '2024-06-26 02:22:58'),
(55, 'sagar@gmail.com', '139', 'PayPal', 'Card', 'PayPal', '3ER16358MC929645D', 'sb-dzv7c30530472@personal.example.com', 'ZWGC', 'N/A', 'pass', 'Test T', 'India', '499', 'USD', '2024-06-26 07:05:08', '2024-06-26 07:05:08'),
(56, 'test@gmail.com', '140', 'PayPal', 'Card', 'PayPal', '4U934859HN068343B', 'sb-dzv7c30530472@personal.example.com', 'ZWGC', 'N/A', 'pass', 'Test T', 'India', '398', 'USD', '2024-06-26 10:19:08', '2024-06-26 10:19:08'),
(58, 'test@gmail.com', '142', 'Stripe', 'Card', 'visa', 'pm_1PWYLlFR1i2uVQl6P4vfmqNG', 'test@gmail.com', '4242', '12/2028', 'pass', 'Test T', 'US', '398', 'usd', '2024-06-28 06:32:19', '2024-06-28 06:32:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_form`
--
ALTER TABLE `customer_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiry`
--
ALTER TABLE `enquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_form`
--
ALTER TABLE `customer_form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `enquiry`
--
ALTER TABLE `enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
