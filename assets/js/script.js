document.addEventListener('DOMContentLoaded', () => {
  if (document.getElementById('loginForm')) {
    initLogin();
  } else if (document.getElementById('registerForm')) {
    initRegister();
  } else if (document.getElementById('addForm')) {
    initDashboard();
  }
});

// ----------------------
// Login Functionality
// ----------------------
function initLogin() {
  const form = document.getElementById('loginForm');
  form.onsubmit = async (e) => {
    e.preventDefault();

    const data = {
      username: form.username.value.trim(),
      password: form.password.value.trim()
    };

    if (!data.username || !data.password) {
      alert('Please fill in all fields');
      return;
    }

    try {
      const res = await fetch('ajax/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });

      const result = await res.json();
      if (result.status === 'success') {
        window.location.href = 'dashboard.php';
      } else {
        alert(result.message || 'Login failed');
      }
    } catch (error) {
      alert('Network error occurred');
    }
  };
}

// ----------------------
// Registration Functionality
// ----------------------
function initRegister() {
  const form = document.getElementById('registerForm');
  form.onsubmit = async (e) => {
    e.preventDefault();

    const data = {
      username: form.username.value.trim(),
      password: form.password.value.trim()
    };

    if (!data.username || !data.password) {
      alert('Please fill in all fields');
      return;
    }

    try {
      const res = await fetch('ajax/register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });

      const result = await res.json();
      if (result.status === 'success') {
        alert('Registration successful! Please log in.');
        window.location.href = 'index.php';
      } else {
        alert(result.message || 'Registration failed');
      }
    } catch (error) {
      alert('Network error occurred');
    }
  };
}

// ----------------------
// Dashboard Functionality
// ----------------------
function initDashboard() {
  const list = document.getElementById('todoList');
  const form = document.getElementById('addForm');
  const searchInput = document.getElementById('searchInput');
  const clearSearchBtn = document.getElementById('clearSearch');
  const filterButtons = document.querySelectorAll('.filter-btn');
  const todoCountEl = document.getElementById('todoCount');
  const searchResultEl = document.getElementById('searchResult');
  const noResultsEl = document.getElementById('noResults');

  let allTodos = [];
  let filteredTodos = [];
  let currentFilter = 'all';
  let currentSearch = '';

  // Load existing todos on page load
  loadTodos();

  // Search functionality
  searchInput.addEventListener('input', (e) => {
    currentSearch = e.target.value.trim().toLowerCase();
    
    if (currentSearch) {
      clearSearchBtn.style.display = 'inline-block';
    } else {
      clearSearchBtn.style.display = 'none';
    }
    
    filterAndDisplayTodos();
  });

  // Clear search
  clearSearchBtn.addEventListener('click', () => {
    searchInput.value = '';
    currentSearch = '';
    clearSearchBtn.style.display = 'none';
    filterAndDisplayTodos();
  });

  // Filter buttons
  filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      // Remove active class from all buttons
      filterButtons.forEach(b => b.classList.remove('active'));
      // Add active class to clicked button
      btn.classList.add('active');
      
      currentFilter = btn.dataset.filter;
      filterAndDisplayTodos();
    });
  });

  // Add new todo
  form.onsubmit = async (e) => {
    e.preventDefault();
    const title = form.title.value.trim();
    if (!title) return;

    try {
      const res = await fetch('ajax/add_todo.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title })
      });

      const result = await res.json();
      if (result.status === 'success') {
        const newTodo = {
          id: result.id,
          title: title,
          is_done: 0
        };
        allTodos.unshift(newTodo);
        form.title.value = '';
        filterAndDisplayTodos();
      } else {
        alert(result.message || 'Error adding task');
      }
    } catch (error) {
      alert('Network error occurred');
    }
  };

  // Logout function
  window.logout = () => {
    window.location.href = 'logout.php';
  };

  // Load and render all todos
  async function loadTodos() {
    try {
      const res = await fetch('ajax/get_todos.php');
      const todos = await res.json();
      allTodos = todos;
      filterAndDisplayTodos();
    } catch (error) {
      alert('Failed to load todos');
    }
  }

  // Filter and display todos based on search and filter
  function filterAndDisplayTodos() {
    let todos = [...allTodos];

    // Apply search filter
    if (currentSearch) {
      todos = todos.filter(todo => 
        todo.title.toLowerCase().includes(currentSearch)
      );
    }

    // Apply status filter
    if (currentFilter === 'pending') {
      todos = todos.filter(todo => !todo.is_done);
    } else if (currentFilter === 'completed') {
      todos = todos.filter(todo => todo.is_done);
    }

    filteredTodos = todos;
    displayTodos();
    updateStats();
  }

  // Display todos in the DOM
  function displayTodos() {
    list.innerHTML = '';
    
    if (filteredTodos.length === 0) {
      if (currentSearch || currentFilter !== 'all') {
        noResultsEl.style.display = 'block';
      } else {
        noResultsEl.style.display = 'none';
      }
      return;
    }

    noResultsEl.style.display = 'none';
    
    filteredTodos.forEach(todo => {
      addTodoItem(todo.id, todo.title, todo.is_done);
    });
  }

  // Update stats display
  function updateStats() {
    const totalTodos = allTodos.length;
    const completedTodos = allTodos.filter(t => t.is_done).length;
    const pendingTodos = totalTodos - completedTodos;
      // Update progress bar
  const progressText = document.getElementById('progress-text');
  const progressPercent = document.getElementById('progress-percentage');
  const progressBarFill = document.getElementById('progress-bar-fill');

  let percent = 0;
  if (totalTodos > 0) {
    percent = Math.round((completedTodos / totalTodos) * 100);
  }

  progressText.textContent = `Completed ${completedTodos} of ${totalTodos}  -> `;
  progressPercent.textContent = ` ${percent}%`;
  progressBarFill.style.width = `${percent}%`;

    let countText = `${totalTodos} task${totalTodos !== 1 ? 's' : ''}`;
    if (totalTodos > 0) {
      countText += ` (${completedTodos} completed, ${pendingTodos} pending)`;
    }
    todoCountEl.textContent = countText;

    // Show search results info
    if (currentSearch || currentFilter !== 'all') {
      const resultCount = filteredTodos.length;
      let resultText = `Showing ${resultCount} task${resultCount !== 1 ? 's' : ''}`;
      
      if (currentSearch) {
        resultText += ` matching "${currentSearch}"`;
      }
      
      if (currentFilter !== 'all') {
        resultText += ` (${currentFilter})`;
      }
      
      searchResultEl.textContent = resultText;
      searchResultEl.style.display = 'inline';
    } else {
      searchResultEl.style.display = 'none';
    }
  }

  // Add a todo item to DOM
  function addTodoItem(id, title, done) {
    const li = document.createElement('li');
    li.id = 'todo-' + id;
    li.className = 'todo-item' + (done ? ' done' : '');
    
    // Highlight search terms
    let displayTitle = escapeHtml(title);
    if (currentSearch) {
      const regex = new RegExp(`(${escapeRegex(currentSearch)})`, 'gi');
      displayTitle = displayTitle.replace(regex, '<mark>$1</mark>');
    }
    
    li.innerHTML = `
      <span class="todo-text" onclick="toggleDone(${id}, ${done ? 0 : 1}, this)">${displayTitle}</span>
      <div class="todo-actions">
        <button class="toggle-btn" onclick="toggleDone(${id}, ${done ? 0 : 1}, this.parentElement.previousElementSibling)">
          ${done ? 'Undo' : 'Done'}
        </button>
        <button class="delete-btn" onclick="deleteTodo(${id})">Delete</button>
      </div>
    `;
    list.appendChild(li);
  }

  // Toggle todo done/undone
  window.toggleDone = async (id, is_done, el) => {
    try {
      const res = await fetch('ajax/update_todo.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, is_done })
      });

      const result = await res.json();
      if (result.status === 'success') {
        // Update the todo in allTodos array
        const todoIndex = allTodos.findIndex(t => t.id == id);
        if (todoIndex > -1) {
          allTodos[todoIndex].is_done = is_done;
        }
        
        // Re-filter and display
        filterAndDisplayTodos();
      }
    } catch (error) {
      alert('Failed to update todo');
    }
  };

  // Delete a todo
  window.deleteTodo = async (id) => {
    if (!confirm('Are you sure you want to delete this task?')) return;

    try {
      const res = await fetch('ajax/delete_todo.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
      });

      const result = await res.json();
      if (result.status === 'success') {
        // Remove from allTodos array
        allTodos = allTodos.filter(t => t.id != id);
        // Re-filter and display
        filterAndDisplayTodos();
      } else {
        alert(result.message || 'Failed to delete todo');
      }
    } catch (error) {
      alert('Network error occurred');
    }
  };

  // Utility function to escape HTML
  function escapeHtml(text) {
    const map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
  }

  // Utility function to escape regex special characters
  function escapeRegex(text) {
    return text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
  }

  
}

// Theme Toggle
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.getElementById('modeToggle');
  if (!toggle) return;

  const body = document.body;
  const savedTheme = localStorage.getItem('theme');

  if (savedTheme === 'dark') {
    body.classList.add('dark-mode');
    toggle.checked = true;
  }

  toggle.addEventListener('change', () => {
    body.classList.toggle('dark-mode');
    localStorage.setItem('theme', body.classList.contains('dark-mode') ? 'dark' : 'light');
  });
});

