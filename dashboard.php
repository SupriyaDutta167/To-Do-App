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
    <div class="dashboard-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="logo-icon">✓</span>
                    <span>TaskFlow</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card total">
                    <div class="stat-label">Total Tasks</div>
                    <div class="stat-value" id="totalCount">0</div>
                </div>
                <div class="stat-card pending">
                    <div class="stat-label">Pending</div>
                    <div class="stat-value" id="pendingCount">0</div>
                </div>
                <div class="stat-card completed">
                    <div class="stat-label">Completed</div>
                    <div class="stat-value" id="completedCount">0</div>
                </div>
            </div>

            <!-- Progress -->
            <div class="progress-section">
                <div class="progress-header">
                    <span class="progress-label">Progress</span>
                    <span class="progress-percent" id="progressPercent">0%</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" id="progress-bar-fill"></div>
                </div>
            </div>

            <!-- Filters -->
            <div class="filter-section">
                <button type="button" class="filter-btn active" data-filter="all">
                    <span class="filter-icon">📋</span>
                    <span>All Tasks</span>
                </button>
                <button type="button" class="filter-btn" data-filter="pending">
                    <span class="filter-icon">⏳</span>
                    <span>Pending</span>
                </button>
                <button type="button" class="filter-btn" data-filter="completed">
                    <span class="filter-icon">✅</span>
                    <span>Completed</span>
                </button>
            </div>

            <!-- Theme Toggle -->
            <div class="theme-toggle-container">
                <span class="theme-label">Dark Mode</span>
                <label class="switch">
                    <input type="checkbox" id="modeToggle">
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Logout -->
            <button onclick="logout()" class="logout-btn">
                🚪 Logout
            </button>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="main-header">
                <button class="mobile-menu-toggle" id="mobileMenuToggle">☰</button>
                <h1 class="page-title">My Tasks</h1>
            </div>

            <!-- Add Task Form -->
            <div class="add-task-card">
                <form id="addForm" class="add-form">
                    <input type="text" name="title" placeholder="What needs to be done?" required>
                    <button type="submit">➕ Add Task</button>
                </form>
            </div>

            <!-- Search -->
            <div class="search-card">
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <span class="search-icon">🔍</span>
                        <input type="text" id="searchInput" placeholder="Search tasks..." class="search-input">
                    </div>
                    <button type="button" id="clearSearch" class="clear-search-btn" style="display: none;">
                        Clear
                    </button>
                </div>
            </div>

            <!-- Hidden original elements for compatibility -->
            <div style="display: none;">
                <span id="todoCount">0 tasks</span>
                <span id="searchResult" style="display: none;"></span>
                <span id="progress-text">Progress</span>
                <span id="progress-percentage">0%</span>
            </div>

            <!-- Todo List -->
            <div class="todos-card">
                <ul id="todoList" class="todo-list"></ul>

                <div id="noResults" class="no-results" style="display: none;">
                    <div class="no-results-icon">🔍</div>
                    <p>No tasks found matching your search.</p>
                </div>
            </div>
        </main>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>