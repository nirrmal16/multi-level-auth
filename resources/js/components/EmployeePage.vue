<template>
    <div class="container mt-4">
        <div class="d-flex justify-content-around">
            <router-link to="/login" class="btn btn-link">Login</router-link>
            <router-link to="/admin-dashboard" class="btn btn-link">Admin Dashboard</router-link>
            <router-link to="/manager-dashboard" class="btn btn-link">Manager Dashboard</router-link>
            <router-link to="/employee-dashboard" class="btn btn-link">Employee Dashboard</router-link>
            <button @click="logout" class="btn btn-danger">Logout</button>
        </div>
        <h1 class="mt-4">Employee Dashboard</h1>
        <div v-if="employee" class="mt-4">
            <h2>{{ employee.name }}</h2>
            <p><strong>Date of Birth:</strong> {{ employee.dob }}</p>
            <p><strong>Date of Joining:</strong> {{ employee.date_of_join }}</p>
            <p><strong>Position:</strong> {{ employee.position }}</p>
        </div>
        <div v-else class="mt-4">
            Loading employee information...
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            employee: null,
        };
    },
    mounted() {
        // Fetch employee information after the component is mounted
        this.fetchEmployeeInfo();
    },
    methods: {
        logout() {

            this.$router.push('/login');
        },
        async fetchEmployeeInfo() {
            try {
                // Make an API request to fetch employee information
                const response = await axios.get('/api/employee-info');
                this.employee = response.data;
            } catch (error) {
                console.error('Error fetching employee information:', error);
            }
        },
    },
};
</script>

<style scoped>
/* Additional styling for better appearance */
body {
    background-color: #f8f9fa; /* Light gray background color */
}

.container {
    max-width: 600px; /* Set a maximum width for better readability */
}

.btn-danger {
    background-color: #dc3545; /* Red color for danger buttons */
    color: #fff; /* White text for contrast */
}

.mt-4 {
    margin-top: 1.5rem; /* Add some margin for spacing */
}

/* Add more styling as needed */
</style>