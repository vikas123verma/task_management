<template>
    <div class="task-form">
        <form @submit.prevent="save">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" v-model="item.title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" id="description" v-model="item.description" required>
            </div>
            <div class="form-group">
                <label for="description">Status</label>
                <select v-model="item.status" required>
                    <option value="pending">Pending</option>
                    <option value="in-progress">In-progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="text" id="deadline" v-model="item.deadline" required>
            </div>
            <button type="submit" >Save</button>
            <div v-if="error">{{ error }}</div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            item:{}
        };
    },
    methods: {
        async save() {
            const token = localStorage.getItem('api_token');
            try {
                const response = await fetch('/api/tasks/', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept':'application/json',
                        'Content-type':'application/json'
                    },
                    body:JSON.stringify(this.item)
                });
                console.log({response})
                this.$router.push('/tasks');
            } catch (error) {
                console.log({error})
            }
        },
    },
};
</script>

<style scoped>
.task-form {
  display: flex;
  flex-direction: column;
  width: 500px;
  margin: 0 auto;
  padding: 50px;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: #f8f8f8;
}

.task-form form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.task-form label {
  font-weight: bold;
  margin-bottom: 5px;
  display: block;
}

.task-form input,
.task-form select {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  font-size: 16px;
}

.task-form button {
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

.task-form button:hover {
  background-color: #3e8e41;
}

.task-form .error {
  color: red;
  font-weight: bold;
  margin-top: 1rem;
}
</style>
