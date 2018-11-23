INSERT INTO category (id, parent_id, sort_order, name, slug) VALUES
(1, NULL, 0, "Development", "development"),
(2, NULL, 1, "Project Management", "project-management"),
(3, NULL, 2, "Mobile", "mobile"),
(4, NULL, 3, "Architecture", "architecture"),
(6, 1, 1, "Java", "java"),
(7, 1, 2, "Javascript", "javascript"),
(8, 1, 3, "PHP", "php"),
(9, 1, 4, "Android", "android"),
(10, 1, 1, "iOS", "ios"),
(11, 10, 2, "Objectif-C", "objectiv-c"),
(12, 10, 3, "Swift", "swift");
