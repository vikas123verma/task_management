<template>
    <div class="login-form">
      <form @submit.prevent="submitLogin">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        <button type="submit">Login</button>
        <div v-if="error">{{ error }}</div>
      </form>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        email: '',
        password: '',
        error: '',
      };
    },
    methods: {
      async submitLogin() {
        try {
          const response = await axios.post('/api/login', {
            email: this.email,
            password: this.password,
          });

          localStorage.setItem('api_token', response.data.data.token);
        //   this.$emit("logout)
          this.$router.push('/tasks');
        } catch (error) {
          this.error = error.response.data.message || 'Login failed';
        }
      },
    },
  };
  </script>

<style scoped>
.login-form {
  display: flex;
  flex-direction: column;
  width: 500px;
  margin: 0 auto;
  padding: 50px;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: #f8f8f8;
}

.login-form form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.login-form label {
  font-weight: bold;
  margin-bottom: 5px;
  display: block;
}

.login-form input,
.login-form select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  font-size: 16px;
}

.login-form button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin-top: 1rem;
  cursor: pointer;
  border-radius: 4px;
}

.login-form button:hover {
  background-color: #3e8e41;
}

.login-form .error {
  color: red;
  font-weight: bold;
  margin-top: 1rem;
}
</style>
