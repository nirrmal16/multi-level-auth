<template>
    <div class="container mt-4">
        <div class="d-flex justify-content-around">
            <router-link to="/login" class="btn btn-link">Login</router-link>
            <router-link to="/admin-dashboard" class="btn btn-link">Admin Dashboard</router-link>
            <router-link to="/manager-dashboard" class="btn btn-link">Manager Dashboard</router-link>
            <router-link to="/employee-dashboard" class="btn btn-link">Employee Dashboard</router-link>
            <button @click="logout" class="btn btn-danger">Logout</button>
        </div>
        <h1 class="mt-4">Team Leader Dashboard</h1>
        <div v-if="manager" class="mt-4">
            <h2>{{ manager.name }} ({{ manager.position }})</h2>
            <p><strong>Date of Birth:</strong> {{ manager.dob }}</p>
            <p><strong>Date of Joining:</strong> {{ manager.date_of_join }}</p>

            <h3>Team Members:</h3>
            <ul>
                <li v-for="teamMember in teamMembers" :key="teamMember.id">{{ teamMember.name }}</li>
            </ul>
        </div>
        <div v-else class="mt-4">
            Loading manager information...
        </div>
    </div>
</template>

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
<script>
export default {
    data() {
        return {
            manager: null,
            teamMembers: [],
        };
    },
    mounted() {
        // Fetch manager information and team members after the component is mounted
        this.fetchManagerInfo();
        this.fetchTeamMembers();
    },
    methods: {
        async fetchManagerInfo() {
            try {
                // Make an API request to fetch manager information
                const response = await axios.get('/api/manager-info');
                this.manager = response.data;
            } catch (error) {
                console.error('Error fetching manager information:', error);
            }
        },
        async fetchTeamMembers() {
            try {
                // Make an API request to fetch team members
                const response = await axios.get('/api/team-members');
                this.teamMembers = response.data;
            } catch (error) {
                console.error('Error fetching team members:', error);
            }
        },
        logout() {
    
            this.$router.push('/login');
        },
    },
};
</script>
