<?php
require_once __DIR__ . '/includes/session.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="theme-toggle">
        <label class="switch">
            <input type="checkbox" id="modeToggle">
            <span class="slider"></span>
        </label>
    </div>

    
    <div class="container">
        <header>
            <h1>Your Todo List</h1>
            <button onclick="logout()" class="logout-btn">Logout</button>
        </header>
        
        <form id="addForm" class="add-form">
            <input type="text" name="title" placeholder="Add new task..." required>
            <button type="submit">Add Task</button>
        </form>

        <!-- Search Section -->
        <div class="search-section">
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Search tasks..." class="search-input">
                <button type="button" id="clearSearch" class="clear-search-btn" style="display: none;">Clear</button>
            </div>
            <div class="filter-buttons">
                <button type="button" class="filter-btn active" data-filter="all">All</button>
                <button type="button" class="filter-btn" data-filter="pending">Pending</button>
                <button type="button" class="filter-btn" data-filter="completed">Completed</button>
            </div>
        </div>
        
        <div class="todo-stats">
            <div class="progress-container">
                <div class="progress-labels">
                    <span id="progress-text">Progress</span>
                    <span id="progress-percentage">0%</span>
                </div>
                <div class="progress-bar-bg">
                    <div id="progress-bar-fill"></div>
                </div>
            </div>

            <span id="todoCount">0 tasks</span>
            <span id="searchResult" style="display: none;"></span>
        </div>

        <ul id="todoList" class="todo-list"></ul>
        
        <div id="noResults" class="no-results" style="display: none;">
            <p>No tasks found matching your search.</p>
        </div>
    </div>
    <script src="assets/js/script.js"></script>
</body>
</html>