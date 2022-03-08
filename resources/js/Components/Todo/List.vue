<template>
<div class="todo-list">
    <div class="filter">
        <div class="mb-3">
        <label for="subject" class="form-label">Subject</label>
        <input v-model="filters.name" class="form-control" placeholder="Subject Name">
        </div>
        <div class="form-check form-check-inline">
            <input v-model="filters.status" class="form-check-input" type="radio" name="filter-status" id="filter-all" value="">
            <label class="form-check-label" for="filter-status">Show All</label>
        </div>
        <div class="form-check form-check-inline">
            <input v-model="filters.status"  class="form-check-input" type="radio" name="filter-status" id="filter-incomplete" value="incomplete">
            <label  class="form-check-label" for="filter-status">Incomplete Only</label>
        </div>
        <div class="form-check form-check-inline">
            <input v-model="filters.status" class="form-check-input" type="radio" name="filter-status" id="filter-completed" value="completed">
            <label class="form-check-label" for="filter-status">Completed Only</label>
        </div>
    </div>
    <table class="table table-hover table-bordered">
        <thead>
            <th scope="col" >#</th>
            <th scope="col" >Status</th>
            <th scope="col"  class="text-left">Subject</th>
        </thead>
        <tbody>
            <tr v-for="( todo, index ) in todos" :key="todo.id">
                <td>
                    {{ index+1 }}

                </td>
                <td>
                    <input type="checkbox" :checked="todo.is_completed" @click="toggleStatus(todo)" />
                </td>
                <td>
                    {{todo.subject}}
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>
<script >
import querifier from 'freedom-js-support/src/utilities/querifier'
export default {
    data() {
        return {
            todos:[],
            filters: {
                name:'',
                status:'',
            },
        }
    },
    watch:{
        filters: {
            deep:true,
            handler() {
                this.getTodos();
            }
        }

    },
    methods: {
        async deleteTodo(todo)
        {
            await axios.delete(`todos/${todo.id}`);
            this.getTodos();
        },
        async getTodos()
        {
            let response = await axios.get(`todos${querifier.getQueryString({search:this.filters})}`);
            this.todos = response.data.data
        },
        async toggleStatus(todo)
        {
            if(todo.is_completed) {
                await axios.patch(`todos/incomplete/${todo.id}`);
            }else {
                await axios.patch(`todos/complete/${todo.id}`);
            }
            this.getTodos();
        }
    },
    async mounted() {
        this.getTodos();
    }
}
</script>
