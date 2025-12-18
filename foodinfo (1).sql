-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2025 at 01:24 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodinfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'jay', '123'),
(2, 'mohitrajsinh', '123');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `feedback` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `feedback`, `submitted_at`) VALUES
(1, 'jay', 'hi your food is great', '2025-09-26 05:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `food_menu`
--

CREATE TABLE `food_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_menu`
--

INSERT INTO `food_menu` (`id`, `name`, `price`, `image`, `description`, `category`) VALUES
(8, 'Spring Rolls', 100.00, '1754896984_pexels-natalie-bond-320378-3569706.jpg', 'Crispy golden rolls filled with fresh veggies and spices, served with a tangy dipping sauce.', 'Starters'),
(9, 'French Fries', 80.00, '1754897021_pexels-dzeninalukac-1583884.jpg', 'Classic crispy and salted potato fries, perfect for snacking.', 'Starters'),
(10, 'Paneer Tikka', 85.00, '1754897109_paneer.jpg', 'Tender paneer cubes marinated in aromatic spices and grilled to smoky perfection.', 'Starters'),
(11, 'Veg Manchurian', 90.00, '1754897190_manch.jpg', 'Soft vegetable balls tossed in a flavorful Indo-Chinese spicy sauce.', 'Starters'),
(12, 'Garlic Bread', 200.00, '1754897302_gare.jpg', 'Toasted bread slices smeared with garlic butter and herbs, warm and fragrant.', 'Starters'),
(13, 'Cheese Nachos', 100.00, '1754897982_d2c393a7-2d23-49da-b70e-6c8db8836cc6.jpg', 'Crunchy nachos loaded with melted cheese and zesty toppings.', 'Starters'),
(14, 'Falafel', 180.00, '1754897529_fal.jpg', 'Deep-fried spiced chickpea balls served with creamy tahini or yogurt dip.', 'Starters'),
(15, 'Mozzarella Sticks', 100.00, '1754897675_pexels-jose-perez-artesano-2150402740-31206989.jpg', 'Crunchy fried breaded mozzarella cheese sticks served with a tangy marinara sauce.', 'Starters'),
(16, 'Bruschetta', 90.00, '1754897775_2014_Bruschetta_The_Larder_Chiang_Mai.jpg', 'Toasted Italian bread topped with fresh diced tomatoes, basil, garlic, and extra virgin olive oil.', 'Starters'),
(17, 'Caprese Salad Skewers', 90.00, '1754897927_Colorfulfullofflavorandeasytomakethis.jpg', 'Fresh mozzarella, cherry tomatoes, and basil leaves drizzled with balsamic glaze.', 'Starters'),
(18, 'Tomato Basil Soup', 200.00, '1754898059_CreamyTomatoBasilSoup_Arichandcreamysoup.jpg', 'Smooth and creamy tomato soup blended with fresh basil leaves and a hint of garlic.', 'Soups'),
(19, 'Vegetable Mulligatawny', 225.00, '1754898146_AuthenticMulligatawnySoupVegan.jpg', 'Spiced Indian vegetable soup with lentils, apples, and a splash of coconut milk.', 'Soups'),
(20, 'Hot and Sour Soup', 225.00, '1754898206_VegetarianHotandSourSoup.jpg', 'A spicy and tangy Chinese soup loaded with mushrooms, tofu, bamboo shoots, and vinegar.', 'Soups'),
(21, 'Sweet Corn Soup', 230.00, '1754898305_Coolcreamyandburstingwithsummerflavorthis.jpg', 'Creamy soup made with sweet corn kernels, veggies, and a touch of pepper.', 'Soups'),
(22, 'Minestrone', 250.00, '1754901922_MinestroneSoupRecipeHealthyandHearty.jpg', 'Classic Italian vegetable soup with beans, pasta, tomatoes, and seasonal veggies in a savory broth.', 'Soups'),
(23, 'Greek Salad', 200.00, '1754901997_ClassicGreekSalad.jpg', 'Crisp cucumbers, ripe tomatoes, olives, red onions, and feta cheese tossed in a tangy oregano vinaigrette.', 'Salads'),
(24, 'Caprese Salad', 200.00, '1754902045_CapreseSaladwithBalsamicReductionClassicand.jpg', 'Slices of fresh mozzarella, juicy tomatoes, and basil drizzled with olive oil and balsamic glaze.', 'Salads'),
(25, 'Quinoa Salad', 200.00, '1754902106_ClassicCapresesaladwithfreshtomatoesandmozzarella.jpg', 'Protein-packed quinoa mixed with chopped veggies, herbs, and a zesty lemon dressing.', 'Salads'),
(26, 'Caesar Salad (Veggie Version)', 300.00, '1754902603_Haveyouevercravedadishthatbalances.jpg', 'Crunchy romaine lettuce with creamy dressing, croutons, and grated Parmesan cheese.', 'Salads'),
(27, 'Cucumber and Avocado Salad', 400.00, '1754902685_23d7c9dc-db47-48f0-b851-55c985b43355.jpg', 'Refreshing cucumber and creamy avocado tossed in lime juice and cilantro.', 'Salads'),
(28, 'Classic Veggie Burger', 80.00, '1754902760_DeliciousHomemadeVeggieBurgersRecipe-dailyrecipestips_com.jpg', 'A wholesome patty made from mixed vegetables and herbs, served with fresh lettuce, tomato, and tangy sauce on a toasted bun.', 'Veg Burgers'),
(29, 'Paneer Tikka Burger', 100.00, '1754902827_SpicyPaneerTikkaBurger_AFusionofIndian.jpg', 'Grilled spiced paneer cubes layered with mint chutney, onions, and fresh greens in a soft bun.\r\n\r\n', 'Veg Burgers'),
(30, 'Falafel Burger', 100.00, '1754902889_EpicFalafelBurgerACoupleCooks.jpg', 'Crunchy Middle-Eastern chickpea falafel patty topped with tahini sauce, pickled veggies, and crisp lettuce.', 'Veg Burgers'),
(31, 'BBQ Veg Burger', 120.00, '1754902972_Burger.jpg', 'Grilled veggie patty smothered in smoky BBQ sauce, topped with onions, pickles, and lettuce.\r\n\r\nSpicy Black Bean Burger', 'Veg Burgers'),
(32, 'Aloo Tikki Burger', 70.00, '1754903034_e9d942d0-0094-490d-834e-d3a8cbe174d4.jpg', 'Indian-style spiced potato patty with tangy tamarind chutney, onions, and fresh coriander.', 'Veg Burgers'),
(33, 'Caprese Veg Burger', 150.00, '1754903135_ChickpeaVeggiePattyRecipe-PlantedandPicked.jpg', 'Fresh mozzarella, juicy tomato slices, basil pesto, and balsamic glaze on a grilled veggie patty.', 'Veg Burgers'),
(34, 'Tandoori Veg Burger', 250.00, '1754903233_PaneerTikkiBurgers-DishbyRish.jpg', 'Paneer or mixed veggie patty marinated in tandoori spices, with cooling cucumber raita and onions.', 'Veg Burgers'),
(35, 'Vegan Black Bean & Sweet Corn Burger', 230.00, '1754903295_EasyVeganBlackBeanBurger_ASimpleTasty.jpg', 'Black bean and sweet corn patty with avocado salsa and chipotle sauce on a vegan bun.\r\n\r\n', 'Veg Burgers'),
(36, 'Moroccan Spiced Veggie Burger', 260.00, '1754904497_spiced-veggie-burgers-ff3134f4.avif', 'Chickpeas, raisins, and spices patty with harissa mayo and fresh mint leaves.', 'Veg Burgers'),
(37, 'Caribbean Veggie Burger', 200.00, '1754904840_VeggieBurgerAFlavorfulPlant-Based.jpg', 'Spiced chickpea and vegetable patty with mango chutney, lettuce, and grilled pineapple.', 'Veg Burgers'),
(38, 'Smoky BBQ Jackfruit Burger', 300.00, '1754905038_SpicyJerkJackfruitBurger.jpg', 'Pulled jackfruit in smoky BBQ sauce, topped with pickles and creamy coleslaw.', 'Veg Burgers'),
(39, 'Roasted Red Pepper & Hummus Burger', 250.00, '1754905175_6505e001dd068a5a901f2aa2_SonomaVeggieBurgerwithRoastedRedPepperHummus.png', 'Grilled roasted red peppers with creamy hummus and fresh arugula.', 'Veg Burgers'),
(40, 'Paneer Tikka Wrap', 150.00, '1754905238_Paneertikka.jpg', 'Spiced grilled paneer cubes with fresh veggies and mint chutney wrapped in a soft tortilla.', 'Wraps & Rolls'),
(41, 'Mexican Bean Wrap', 190.00, '1754905309_one-panMexicanquinoawraps.jpg', 'Spicy black beans, corn salsa, avocado, and cheese wrapped in a spinach tortilla.', 'Wraps & Rolls'),
(42, 'Grilled Veggie Roll', 200.00, '1754905382_GrilledVeggieWrapsRecipe-MushroomSalus.jpg', 'Char-grilled zucchini, peppers, and mushrooms with garlic aioli wrapped in flatbread.', 'Wraps & Rolls'),
(43, 'Caribbean Veggie Roll', 150.00, '1754905450_Ingredients_FortheFilling_1cupcabbage.jpg', 'Spiced chickpeas, mango chutney, and grilled pineapple wrapped in flatbread.', 'Wraps & Rolls'),
(44, 'Caesar Veg Wrap', 200.00, '1754905620_4', 'Crisp romaine lettuce, parmesan cheese, croutons, and creamy Caesar dressing in a tortilla.', 'Wraps & Rolls'),
(45, 'Paneer Butter Masala', 700.00, '1754905714_fabef23b-71d5-4f80-8ed9-a222a6f3c0fc.jpg', 'Soft paneer cubes cooked in rich, creamy tomato and butter gravy, garnished with fresh coriander.', 'Main Course'),
(46, 'Gatte Ki Sabzi', 800.00, '1754909706_GatteKiSabziRecipe_RajasthaniBesankeGatte.jpg', 'Gram flour dumplings cooked in a spiced yogurt gravy.', 'Main Course'),
(47, 'Palak Paneer', 500.00, '1754905881_dd2027eb-292c-48b7-b4ac-ee402c81194b.jpg', 'Fresh spinach cooked with paneer cubes in a smooth, spiced gravy.', 'Main Course'),
(48, 'Mixed Vegetable Curry', 800.00, '1754905961_fc5d0158-308f-4d33-9b21-58888519715c.jpg', 'Seasonal veggies cooked in a balanced blend of spices and herbs.', 'Main Course'),
(49, 'Chana Masala', 550.00, '1754906033_Warmspicyandoh-so-creamyThisChanaMasala.jpg', 'Spicy chickpeas cooked in tangy tomato gravy with aromatic spices.', 'Main Course'),
(50, 'Matar Paneer', 450.00, '1754906087_ThisMatarPaneerfeaturesspongypaneercubesand.jpg', 'Paneer and green peas cooked in a flavorful onion-tomato gravy.', 'Main Course'),
(51, 'Malai Kofta', 900.00, '1754907509_MalaiKofta-CaliforniaRaisins.jpg', 'Soft vegetable dumplings in a rich, creamy, mildly spiced sauce.', 'Main Course'),
(52, 'Kadai Paneer', 750.00, '1754907614_8cb41152-1498-472a-ab35-93d22a732af2.jpg', 'Paneer cubes cooked with bell peppers, tomatoes, and traditional Indian spices in a thick gravy.', 'Main Course'),
(53, 'Rajma Masala', 600.00, '1754908761_5af246e2-3042-4904-903c-f5d6a2ef5b60.jpg', 'Red kidney beans simmered in a thick, flavorful tomato-based gravy.', 'Main Course'),
(54, 'Paneer Bhurji', 900.00, '1754908855_NehaAnshu_AmritsariPaneerBhurjiRecipeThisPaneerBhurjiisnotyourregularbhurjitheresanaddedtwistandtastethatwillmakeyour_Instagram.jpg', 'Scrambled paneer cooked with onions, tomatoes, and mild spices.', 'Main Course'),
(55, 'Matar Paneer', 1000.00, '1754908973_LeMatarPaneerestunplatindienemblmatique.jpg', 'Peas and paneer cooked together in a lightly spiced tomato-based gravy.', 'Main Course'),
(56, 'Shahi Paneer', 1000.00, '1754909025_shahipaneerisonerichandroyalpreparation.jpg', 'Paneer cooked in a luxurious, mildly sweet and creamy cashew and saffron sauce.', 'Main Course'),
(57, 'Chili Paneer (Indo-Chinese)', 950.00, '1754909100_e2d0eafc-f523-47c7-8db4-0e96521ec42f.jpg', 'Paneer cubes stir-fried with bell peppers, onions, and spicy chili sauce.', 'Main Course'),
(58, 'Sarson Ka Saag', 1000.00, '1754909160_SarsonKaSaag_AtasteofPunjabsheartand.jpg', 'Traditional mustard greens cooked slow and low with spices, served with makki di roti.', 'Main Course'),
(59, 'Chili Paneer (Punjabi Style)', 1000.00, '1754909294_KoreanstyleChiliPaneer.jpg', 'Paneer cubes stir-fried with bell peppers, onions, and spicy chili sauce with a Punjabi twist.', 'Main Course'),
(60, 'Paneer Biryani', 700.00, '1754909388_PaneerBiryani_StovetopPaneerDumBiryani.jpg', 'Basmati rice layered with marinated paneer cubes and spices, slow-cooked to perfection.', 'Rice & Biryani'),
(61, 'Punjabi Veg Biryani', 500.00, '1754909794_Smokyspicyandslow-cookedtoperfection.jpg', 'Fragrant basmati rice cooked with mixed vegetables, yogurt, and Punjabi spices, slow-cooked to perfection.', 'Rice & Biryani'),
(62, 'Hyderabadi Veg Biryani', 600.00, '1754909932_VegBiryani.jpg', 'Layered biryani with vegetables, saffron, and aromatic spices, famous for its rich flavor and aroma.', 'Rice & Biryani'),
(63, 'Mushroom Biryani', 400.00, '1754909999_MushroomBiryani_VeganMushroomPulao_BestMushroomBiryani.jpg', 'Flavored basmati rice layered with spiced mushrooms and cooked with whole spices.', 'Rice & Biryani'),
(65, 'Tawa Biryani', 500.00, '1754910222_Freshlycookeddeliciousvegbiryaniricedish.jpg', 'Quick and spicy biryani cooked on a hot griddle with mixed vegetables and masalas.', 'Rice & Biryani');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(8,2) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT 'Pending',
  `order_type` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `order_time` time DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT 'Pending',
  `txn_id` varchar(100) DEFAULT NULL,
  `payment_ref` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `order_date`, `status`, `order_type`, `payment_method`, `order_time`, `payment_status`, `txn_id`, `payment_ref`) VALUES
(2, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(3, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(4, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(5, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(6, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(7, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(8, 0, 170.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(9, 0, 250.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(10, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(11, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(12, 0, 385.00, '2025-08-07 00:00:00', 'Pending', '', '', '00:00:00', 'Pending', NULL, NULL),
(13, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '05:36:00', 'Pending', NULL, NULL),
(14, 0, 55.00, '2025-08-07 00:00:00', 'Pending', '', '', '05:41:21', 'Pending', NULL, NULL),
(15, 0, 100.00, '2025-08-07 00:00:00', 'Pending', '', '', '05:42:20', 'Pending', NULL, NULL),
(16, 0, 85.00, '2025-08-07 00:00:00', 'Pending', '', '', '05:42:42', 'Pending', NULL, NULL),
(17, 1, 100.00, '2025-08-11 00:00:00', 'Pending', '', '', '08:53:49', 'Pending', NULL, NULL),
(18, 1, 687.00, '2025-08-11 00:00:00', 'Pending', '', '', '09:46:16', 'Pending', NULL, NULL),
(19, 1, 400.00, '2025-08-11 00:00:00', 'Pending', '', '', '13:39:18', 'Pending', NULL, NULL),
(20, 1, 1800.00, '2025-08-18 00:00:00', 'Pending', '', '', '10:05:23', 'Pending', NULL, NULL),
(21, 4, 300.00, '2025-09-26 00:00:00', 'Pending', '', '', '07:33:36', 'Pending', NULL, NULL),
(22, 4, 100.00, '2025-09-26 00:00:00', 'Pending', '', '', '08:13:08', 'Pending', NULL, NULL),
(23, 4, 180.00, '2025-09-26 00:00:00', 'Pending', 'Dine-in', '', '08:16:24', 'Pending', NULL, NULL),
(24, 4, 80.00, '2025-09-26 00:00:00', 'Pending', 'Home Delivery', '', '08:16:46', 'Pending', NULL, NULL),
(25, 4, 80.00, '2025-09-26 00:00:00', 'Delivered', 'Home Delivery', 'Online', '08:18:45', 'Pending', NULL, NULL),
(26, 4, 80.00, '2025-09-26 00:00:00', 'Pending', 'Dine-in', 'Online', '08:24:27', 'Paid', NULL, NULL),
(27, 4, 80.00, '2025-09-26 00:00:00', 'Pending', 'Dine-in', 'Online', '08:24:45', 'Paid', NULL, NULL),
(28, 4, 80.00, '2025-09-26 00:00:00', 'Pending', 'Dine-in', 'COD', '08:33:02', 'Paid', NULL, NULL),
(29, 4, 80.00, '2025-09-26 00:00:00', 'Delivered', 'Home Delivery', 'Online', '08:37:03', 'Paid', '977717779', 'TXN_68d6348fa9342'),
(30, 4, 80.00, '2025-09-26 00:00:00', 'Pending', 'Dine-in', 'Online', '08:37:20', 'Paid', '89788998', 'TXN_68d634a06fcc0'),
(31, 1, 0.00, '2025-10-13 00:00:00', 'Pending', 'Dine-in', 'COD', '07:39:45', 'Pending', NULL, NULL),
(32, 1, 80.00, '2025-11-25 00:00:00', 'Pending', 'Home Delivery', 'COD', '01:20:28', 'Pending', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `food_id`, `quantity`, `price`) VALUES
(1, 12, 4, 7, 55.00),
(2, 13, 2, 1, 85.00),
(3, 14, 4, 1, 55.00),
(4, 15, 1, 1, 100.00),
(5, 16, 2, 1, 85.00),
(6, 17, 1, 1, 100.00),
(7, 18, 6, 1, 2.00),
(8, 18, 5, 1, 585.00),
(9, 18, 15, 1, 100.00),
(10, 19, 63, 1, 400.00),
(11, 20, 54, 1, 900.00),
(12, 20, 52, 1, 750.00),
(13, 20, 43, 1, 150.00),
(14, 21, 29, 1, 100.00),
(15, 21, 28, 1, 80.00),
(16, 21, 31, 1, 120.00),
(17, 22, 8, 1, 100.00),
(18, 23, 9, 1, 80.00),
(19, 23, 8, 1, 100.00),
(20, 24, 9, 1, 80.00),
(21, 25, 9, 1, 80.00),
(22, 26, 9, 1, 80.00),
(23, 27, 9, 1, 80.00),
(24, 28, 9, 1, 80.00),
(25, 29, 9, 1, 80.00),
(26, 30, 9, 1, 80.00),
(27, 0, 9, 1, 80.00),
(28, 0, 18, 1, 200.00),
(29, 0, 9, 1, 80.00),
(30, 32, 9, 1, 80.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `verified`) VALUES
(1, 'jay_patel', 'jay.ambaliya@gmail.com', '7777', '7096979174', 1),
(2, 'mohitrajsinh_jadeja', 'mohiraj@gamil.com', '7777', '9012577777', 1),
(4, 'Burger', 'Jay.ambaliya.yt5@gmail.com', '1234', '7096979175', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_menu`
--
ALTER TABLE `food_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food_menu`
--
ALTER TABLE `food_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
