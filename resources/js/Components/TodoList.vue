<template>
<div class="todo-list">
    <div class="filter">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Filters
        </h2>
        <div class="mb-3">
        <BreezeLabel for="subject" value="Subject"></BreezeLabel>
        <BreezeInput placeholder="Subject Name"  type="text" class="mt-1 block w-full" v-model="filters.subject" required autofocus autocomplete="name" />
        </div>
        <div class="mb-3" @click.capture="filter.status = 'incomplete'">
            <input v-model="filters.status"  class="form-check-input" type="radio" name="filter-status" id="filter-incomplete" value="incomplete">
            <label  class="mx-1 form-check-label" for="filter-status">Incomplete Only</label>
        </div>
        <div class="mb-3" @click.capture="filter.status = 'completed'">
            <input v-model="filters.status" class="form-check-input" type="radio" name="filter-status" id="filter-completed" value="completed">
            <label class="mx-1 form-check-label" for="filter-status">Completed Only</label>
        </div>
        <div class="mb-3" @click.capture="filter.status = ''">
            <input v-model="filters.status" class="form-check-input" type="radio" name="filter-status" id="filter-all" value="">
            <label class="mx-1 form-check-label" for="filter-status">Show All</label>
        </div>
    </div>
    <div class="mt-7">
        <BreezeLabel name="new-subject" value="New Todo"></BreezeLabel>
        <BreezeInput type="text" name="new-subject" v-model="todo.subject"></BreezeInput>
        <BreezeButton class="mx-3" @click="newTodo">+</BreezeButton>
    </div>
    <div class="mt-4">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lists
        </h2>
        <table class="table table-hover table-bordered">
            <thead>
                <th class="px-4 text-left" >#</th>
                <th class="px-4 text-left" >Status</th>
                <th class="px-4 text-left">Subject</th>
                <th class="px-4 text-left">Actions</th>
            </thead>
            <tbody>
                <tr v-for="( todo, index ) in todos" :key="todo.id">
                    <td class="px-4">
                        {{ index+1 }}

                    </td>
                    <td class="px-4">
                        <input type="checkbox" :checked="todo.is_completed" @click="toggleStatus(todo)" />
                    </td>
                    <td class="px-4" width="70%">
                            <BreezeInput type="text" class="mt-1 block w-full" required v-model="todos[index].subject"></BreezeInput>
                    </td>
                    <td class="px-4">
                        <BreezeButton class="mx-1" @click="deleteTodo(todo)">Trash</BreezeButton>
                        <BreezeButton class="mx-1" @click="updateTodo(todo)">Save</BreezeButton>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</template>
<script >
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import querifier from 'freedom-js-support/src/utilities/querifier'
export default {
    data() {
        return {
            todo:{

            },
            todos:[],
            filters: {
                subject:'',
                status:'incomplete',
            },
            caller:null,
        }
    },
    watch:{
        filters:{
            deep:true,
            handler() {
                if(this.caller) {
                    clearTimeout(this.caller);
                }
                this.caller = setTimeout(()=>{ this.getTodos()}, 300);
            }
        }

    },
    methods: {
        async newTodo()
        {
            try{
                await axios.post(`todos`,this.todo);
                this.getTodos();
                this.todo = {}
            }catch(error) {
                window.alert(error.response.data.message)
            }
        },
        async updateTodo(todo)
        {
            try{
                await axios.put(`todos/${todo.id}`,todo);
                this.getTodos();
                window.alert("Update successful")
            }catch(error) {
                window.alert(error.response.data.message)
            }
        },
        async deleteTodo(todo)
        {
            await axios.delete(`todos/${todo.id}`);
            this.getTodos();
            window.alert("Delete successful")
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
    },
    components:{
        BreezeButton,
        BreezeInput,
        BreezeLabel
    },
}
</script>
