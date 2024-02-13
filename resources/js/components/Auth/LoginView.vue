
<template>
    <div>
      <div class="d-flex justify-content-around">
        <router-link to="/login" class="btn btn-link">Login</router-link>
  
        <router-view></router-view>
      </div>
  
      <h2>Login</h2>
  
      <form method="POST" action="{{ route('login') }}">
        @csrf        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="form.email" class="form-control" required>
        </div>
  
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="form.password" class="form-control" required>
        </div>
  
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
  
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        form: {
          email: '',
          password: '',
        },
      };
    },
    methods: {
      async login() {
        try {
          // Simulate a login request to the server
          const response = await this.$axios.post('/api/login', this.form);
  
          // Assuming the server responds with the user's role
          const userRole = response.data.role;
  
          // Redirect based on the user's role
          this.$router.push({ name: `${userRole.toLowerCase()}-dashboard` });
        } catch (error) {
          console.error('Login failed:', error);
          // Handle login failure, show error message, etc.
        }
      },
    },
  };
  </script>

<style scoped>
  /* Add your custom styling here */

  div {
    max-width: 400px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 50px;
  }

  h2 {
    text-align: center;
    color: #333;
  }

  form {
    margin-top: 20px;
  }

  label {
    margin-bottom: 8px;
    color: #333;
  }

  input {
    margin-bottom: 15px;
  }

  button {
    cursor: pointer;
  }

  a {
    margin-top: 10px;
    display: block;
    text-align: center;
  }

  .d-flex {
    margin-bottom: 20px;
  }

</style>