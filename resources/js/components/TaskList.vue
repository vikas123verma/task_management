<template>
    <router-link id="add-button" to="/task/add">Add Task</router-link>
    <br>
    <table  class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items" :key="item.uuid">
                <td>{{ item.title }}</td>
                <td>{{ item.status }}</td>
                <td>{{ item.deadline }}</td>
                <td>
                    <button @click="editItem(item.uuid)">Edit</button>
                    <button @click="deleteItem(item.uuid)">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<script>
export default {
    data() {
        return {
            items: []
        };
    },
    async mounted() {
        this.items = await this.fetchData();
    },
    methods: {
        async fetchData() {
            const token = localStorage.getItem('api_token');
            const response = await fetch('/api/tasks', {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                },
            });
            const res = await response.json()
            console.log({ data: res.data })
            return res.data;
        },
        async editItem(uuid) {
            this.$router.push(`/tasks/${uuid}`);
        },
        async deleteItem(uuid) {
            const token = localStorage.getItem('api_token');
            try {
                const response = await fetch('/api/tasks/' + uuid, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json',
                    }
                });
                this.items = await this.fetchData();
            } catch (error) {
                console.log({ error })
            }
        },
    },
};
</script>
<style>
#add-button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  border-radius: 4px;
  position: relative;
  float: right;
}
.data-table {
  width: 100%;
  border-collapse: collapse;
  margin: 2rem 0;
}

.data-table thead th,
.data-table tbody td {
  padding: 0.5rem 1rem;
  border: 1px solid #ddd;
  text-align: left;
}

.data-table thead th {
  background-color: #f2f2f2;
}

</style>
