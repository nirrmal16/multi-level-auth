<template>
    <div>
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="d-flex justify-content-around mb-3">
            <router-link to="/login" class="btn btn-link">Login</router-link>
            <router-link to="/admin-dashboard" class="btn btn-link">Admin Dashboard</router-link>
            <router-link to="/manager-dashboard" class="btn btn-link">Manager Dashboard</router-link>
            <router-link to="/employee-dashboard" class="btn btn-link">Employee Dashboard</router-link>
            <button @click="logout" class="btn btn-danger">Logout</button>
        </div>

        <!-- Display Admin Information -->
        <div v-if="admin" class="mb-3">
            <h2>{{ admin.name }} ({{ admin.position }})</h2>
            <p>Date of Birth: {{ admin.dob }}</p>
            <p>Date of Joining: {{ admin.date_of_join }}</p>
        </div>
        <div v-else>
            Loading admin information...
        </div>

        <div class="mb-3">
            <label for="searchQuery">Search:</label>
            <input type="text" id="searchQuery" v-model="searchQuery" @input="search" class="form-control">
        </div>

        <!-- Managers Section -->
        <h2>All Managers:</h2>
        <ul v-if="managersToShow.length > 0" class="list-group mb-3">
            <li v-for="manager in managersToShow" :key="manager.id" class="list-group-item d-flex justify-content-between align-items-center">
                {{ manager.name }}
                <div>
                    <button @click="editManager(manager)" class="btn btn-info btn-sm">Edit</button>
                    <button @click="confirmDelete('manager', manager.id)" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </li>
        </ul>
        <div v-else>
            No managers found.
        </div>

        <!-- Employees Section -->
        <h2>All Employees:</h2>
        <ul v-if="employeesToShow.length > 0" class="list-group mb-3">
            <li v-for="employee in employeesToShow" :key="employee.id" class="list-group-item d-flex justify-content-between align-items-center">
                {{ employee.name }}
                <div>
                    <button @click="editEmployee(employee)" class="btn btn-info btn-sm">Edit</button>
                    <button @click="confirmDelete('employee', employee.id)" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </li>
        </ul>
        <div v-else>
            No employees found.
        </div>


        <!-- Modals for CRUD Operations -->
        <b-modal v-if="showManagerEditModal" title="Edit Manager">
            <form @submit.prevent="saveManagerChanges">
                <label for="managerName">Name:</label>
                <input type="text" id="managerName" v-model="selectedManager.name" required>

                <label for="managerDOB">Date of Birth:</label>
                <input type="date" id="managerDOB" v-model="selectedManager.dob" required>

                <label for="managerDateOfJoin">Date of Joining:</label>
                <input type="date" id="managerDateOfJoin" v-model="selectedManager.date_of_join" required>

                <button type="submit">Save Changes</button>
            </form>
        </b-modal>

        <b-modal v-if="showEmployeeEditModal" title="Edit Employee">
            <form @submit.prevent="saveEmployeeChanges">
                <label for="employeeName">Name:</label>
                <input type="text" id="employeeName" v-model="selectedEmployee.name" required>

                <label for="employeeDOB">Date of Birth:</label>
                <input type="date" id="employeeDOB" v-model="selectedEmployee.dob" required>

                <label for="employeeDateOfJoin">Date of Joining:</label>
                <input type="date" id="employeeDateOfJoin" v-model="selectedEmployee.date_of_join" required>

                <button type="submit">Save Changes</button>
            </form>
        </b-modal>
     

        <div>
       
            <div class="mb-3">
                <h2>Add Employee</h2>
                <form @submit.prevent="addEmployee" class="form-inline">
                    <label for="employeeName">Name:</label>
                    <input type="text" id="employeeName" v-model="newEmployee.name" required>
        
                    <label for="employeeDOB">Date of Birth:</label>
                    <input type="date" id="employeeDOB" v-model="newEmployee.dob" required>
        
                    <label for="employeeDateOfJoin">Date of Joining:</label>
                    <input type="date" id="employeeDateOfJoin" v-model="newEmployee.date_of_join" required>
                        <button type="submit" class="btn btn-primary">Add Employee</button>
                </form>
            </div>
        <!-- Add Manager Form -->
 
        <div class="mb-3">
            <h2>Add Manager</h2>
            <form @submit.prevent="addManager" class="form-inline">
            <label for="managerName">Name:</label>
            <input type="text" id="managerName" v-model="newManager.name" required>

            <label for="managerDOB">Date of Birth:</label>
            <input type="date" id="managerDOB" v-model="newManager.dob" required>

            <label for="managerDateOfJoin">Date of Joining:</label>
            <input type="date" id="managerDateOfJoin" v-model="newManager.date_of_join" required>

            <button type="submit">Add Team leader</button>
        </form>
        </div>
   
          <!-- Modals for CRUD Operations -->
          <b-modal v-if="showManagerEditModal" title="Edit Manager">
            <form @submit.prevent="saveManagerChanges">
                <!-- ... (same as before) -->
                <button type="submit">Save Changes</button>
            </form>
        </b-modal>

        <b-modal v-if="showEmployeeEditModal" title="Edit Employee">
            <form @submit.prevent="saveEmployeeChanges">
                <!-- ... (same as before) -->
                <button type="submit">Save Changes</button>
            </form>
        </b-modal>

        <b-modal v-if="showDeleteConfirmation" title="Delete Confirmation">
            <p>Are you sure you want to delete this {{ deleteType }}?</p>
            <button @click="deleteItem">Delete</button>
            <button @click="cancelDelete">Cancel</button>
        </b-modal>

        <button @click="exportToExcel" class="btn btn-success">Export to Excel</button>

        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                    <a class="page-link" @click="changePage(currentPage - 1)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ 'active': currentPage === page }">
                    <a class="page-link" @click="changePage(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                    <a class="page-link" @click="changePage(currentPage + 1)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    data() {
        return {
            admin: null,
            managers: [],
            employees: [],
            showManagerEditModal: false,
            showEmployeeEditModal: false,
            selectedManager: {
                name: '',
                dob: '',
                date_of_join: '',
            },
            selectedEmployee: {
                name: '',
                dob: '',
                date_of_join: '',
            },
            newEmployee: {
                name: '',
                dob: '',
                date_of_join: '',
            },
            newManager: {
                name: '',
                dob: '',
                date_of_join: '',
            },
            searchQuery: '',
            currentPage: 1,
            itemsPerPage: 5, // Adjust as needed
            showDeleteConfirmation: false,
            deleteType: '',
            itemIdToDelete: null,
        };
    },
    mounted() {
        // Fetch admin information, list of managers, and list of employees after the component is mounted
        this.fetchAdminInfo();
        this.fetchManagers();
        this.fetchEmployees();
        
    },
    computed: {
        managersToShow() {
            // Apply search and pagination to managers list
            return this.filterAndPaginateList(this.managers);
        },
        employeesToShow() {
            // Apply search and pagination to employees list
            return this.filterAndPaginateList(this.employees);
        },
        totalPages() {
            // Calculate the total number of pages based on the itemsPerPage
            const totalItems = this.deleteType === 'manager' ? this.managers.length : this.employees.length;
            return Math.ceil(totalItems / this.itemsPerPage);
        },
    },
    methods: {
        logout() {
       
            this.$router.push('/login');
        },
        async fetchAdminInfo() {
            try {
                // Make an API request to fetch admin information
                const response = await axios.get('/api/admin-info');
                this.admin = response.data;
            } catch (error) {
                console.error('Error fetching admin information:', error);
            }
        },
        async fetchManagers() {
            try {
                // Make an API request to fetch all managers
                const response = await axios.get('/api/all-managers');
                this.managers = response.data;
            } catch (error) {
                console.error('Error fetching managers:', error);
            }
        },
        async fetchEmployees() {
            try {
                // Make an API request to fetch all employees
                const response = await axios.get('/api/all-employees');
                this.employees = response.data;
            } catch (error) {
                console.error('Error fetching employees:', error);
            }
        },
        editManager(manager) {
            this.selectedManager = { ...manager }; // Clone the object to avoid modifying the original object
            this.showManagerEditModal = true;
        },
        editEmployee(employee) {
            this.selectedEmployee = { ...employee }; // Clone the object to avoid modifying the original object
            this.showEmployeeEditModal = true;
        },
        saveManagerChanges() {
            // Implement logic to save changes to the selected manager
            console.log('Save changes for manager:', this.selectedManager);
            this.showManagerEditModal = false;
        },
        saveEmployeeChanges() {
            // Implement logic to save changes to the selected employee
            console.log('Save changes for employee:', this.selectedEmployee);
            this.showEmployeeEditModal = false;
        },
        deleteManager(managerId) {
            // Implement logic to delete manager by ID
            console.log('Delete manager with ID:', managerId);
        },
        deleteEmployee(employeeId) {
            // Implement logic to delete employee by ID
            console.log('Delete employee with ID:', employeeId);
        },
        
        async addEmployee() {
            try {
                // Make an API request to add a new employee
                const response = await axios.post('/api/admin/add-employee', this.newEmployee);
                console.log('Employee added:', response.data);

                // Reset the form
                this.newEmployee = {
                    name: '',
                    dob: '',
                    date_of_join: '',
                };
            } catch (error) {
                console.error('Error adding employee:', error);
            }
        },

        async addManager() {
            try {
                // Make an API request to add a new manager
                const response = await axios.post('/api/admin/add-manager', this.newManager);
                console.log('Manager added:', response.data);

                // Reset the form
                this.newManager = {
                    name: '',
                    dob: '',
                    date_of_join: '',
                };
            } catch (error) {
                console.error('Error adding manager:', error);
            }
        },
        search() {
            // Triggered on search input change
            this.currentPage = 1;
        },

        filterAndPaginateList(originalList) {
            // Apply search filtering
            const filteredList = originalList.filter(item =>
                item.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );

            // Apply pagination
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            return filteredList.slice(startIndex, startIndex + this.itemsPerPage);
        },

        confirmDelete(type, itemId) {
            // Show the delete confirmation modal
            this.showDeleteConfirmation = true;
            this.deleteType = type;
            this.itemIdToDelete = itemId;
        },

        deleteItem() {
            // Implement logic to delete item by type and ID
            if (this.deleteType === 'manager') {
                this.deleteManager(this.itemIdToDelete);
            } else if (this.deleteType === 'employee') {
                this.deleteEmployee(this.itemIdToDelete);
            }

            // Close the delete confirmation modal
            this.showDeleteConfirmation = false;
        },

        cancelDelete() {
            // Cancel the delete operation
            this.showDeleteConfirmation = false;
        },

        changePage(page) {
            // Change the current page
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        exportToExcel() {
            // Combine managers and employees into a single array for export
            const dataToExport = [...this.managers, ...this.employees];

            // Define the Excel sheet structure
            const ws = XLSX.utils.json_to_sheet(dataToExport);

            // Create a new Excel workbook and add the sheet
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, 'Employees_Managers');

            // Save the workbook as an Excel file
            XLSX.writeFile(wb, 'employees_managers.xlsx');
        },
    },
};
</script>
<style scoped>
/* Add your custom CSS styling here */

body {
  background-color: #f8f9fa; /* Light gray background color */
}

h1 {
  color: #007bff; /* Blue color for headings */
}

.btn-primary {
  background-color: #007bff; /* Blue color for primary buttons */
  color: #fff; /* White text for contrast */
}

.btn-danger {
  background-color: #dc3545; /* Red color for danger buttons */
  color: #fff; /* White text for contrast */
}

.list-group-item {
  background-color: #fff; /* White background for list items */
}

.list-group-item:hover {
  background-color: #f8f9fa; /* Light gray background on hover */
}

.form-control {
  border: 1px solid #ced4da; /* Light gray border for form controls */
}

.pagination {
  margin-top: 20px;
}

/* Add animations for fun */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.fade-in {
  animation: fadeIn 1s ease-out;
}

</style>