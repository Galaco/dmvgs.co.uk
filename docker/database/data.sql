SET time_zone = "+00:00";

INSERT INTO `forum` (`id`, `title`, `description`, `forum_category_id`, `minimum_access`) VALUES
(1, 'Announcements', 'Public announcements and information', 1, 'member'),
(2, 'Introductions', 'Make your introduction here', 1, 'member'),
(3, 'The Pub', 'For general chat that doesn''t fit other categories', 3, 'member'),
(4, 'General Gaming', 'Video game discussions. Either new or old', 3, 'member'),
(5, 'Tech Center', 'Talk about new tech, hardware etc here', 3, 'member'),
(6, 'News & Debate', 'Discussion of hot topics and the news', 3, 'member'),
(7, 'Spam', 'Post your worthless content that has nothing to do with anything here', 3, 'member'),
(8, 'Trash Can', 'Old and moved threads end up here. Anything here may be deleted without warning', 4, 'member'),
(2612, 'Staff chat', 'staff only.', 4, 'staff');

INSERT INTO `forum_category` (`id`, `category`) VALUES
(3, 'General Discussion'),
(1, 'News & Introductions'),
(4, 'Other');

INSERT INTO `static_email_content` (`id`, `type`, `content`) VALUES
(1, 'reset_password', 'DMVGS\r\n\r\nYou have received this email because your account has requested a password reset request.\r\n\r\nTo reset you password please follow this link: "http://dmvgs.co.uk/forum/account/reset?uuid=__X__"\r\n\r\nIf you believe you have receieved this in error, please contact an administrator.');


