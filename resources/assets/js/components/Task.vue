<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <button @click="initAddTask()" class="btn btn-primary btn-xs pull-right">
              + Add New Task
            </button>
            My Tasks
          </div>

          <div class="panel-body">
            <table class="table table-bordered table-striped table-responsive" v-if="tasks.length > 0">
              <tbody>
              <tr>
                <th>
                  No.
                </th>
                <th>
                  Name
                </th>
                <th>
                  Image
                </th>
                <th>
                  Started Date
                </th>
                <th>
                  Category
                </th>
                <th>
                  option
                </th>
                <th>
                  Checked Value
                </th>
                <th>
                  Description
                </th>
                <th>
                  Action
                </th>
              </tr>
              <tr v-for="(task, index) in tasks">
                <td>{{ index + 1 }}</td>  <!-- index + 1 for indexing-->
                <td>
                  {{ task.name }}
                </td>
                <td>
                  <img v-bind:src="'/upload/'+task.image">
                </td>
                <td>
                  {{ task.started_date }}
                </td>
                <td>
                  {{ task.category }}
                </td>
                <td>
                  {{ task.option }}
                </td>
                <td>
                  <button class="btn btn-success btn-xs">{{ task.checked }}</button>

                </td>
                <td>
                  {{ task.description }}
                </td>
                <td>
                  <button @click="initUpdate(index)" class="btn btn-success btn-xs">Edit</button>
                  <button @click="deleteTask(index)" class="btn btn-danger btn-xs">Delete</button>
                </td>

              </tr>

              </tbody>

            </table>

            <pagination :data="laravelData" @pagination-change-page="getResults"></pagination>

          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="add_task_model">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Add New Task</h4>
          </div>
          <div class="modal-body">

            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>

            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" name="name" id="name" placeholder="Task Name" class="form-control"
                     v-model="task.name">
            </div>
            <div class="form-group">
              <label for="name">Started Date:</label>
              <input type="date" name="date" format="dd/mm/yyyy" class="form-control"
                     v-model="task.date">
              <!-- <date-pick v-model="task.date"></date-pick> -->
            </div>

            <div class="form-group">
              <label for="name">Select Category:</label><br>
              <input type="radio" id="one" value="One" v-model="task.category">
              <label for="one">One</label>
              <input type="radio" id="two" value="Two" v-model="task.category">
              <label for="two">Two</label>
              <br>
            </div>

            <div class="form-group">
              <label for="name">Select Option:</label><br>
              <select v-model="task.selected">
                <option disabled value="">Please select one</option>
                <option>A</option>
                <option>B</option>
                <option>C</option>
              </select>

            </div>

            <div class="form-group">
              <label for="name">Check Any Vaue:</label><br>
              <input type="checkbox" id="jack" value="Jack" v-model="task.checkedNames">
              <label for="jack">Jack</label>
              <input type="checkbox" id="john" value="John" v-model="task.checkedNames">
              <label for="john">John</label>
              <input type="checkbox" id="mike" value="Mike" v-model="task.checkedNames">
              <label for="mike">Mike</label>
              <br>
              <span>Checked names: {{ task.checkedNames }}</span>
            </div>


            <div class="form-group">
              <label for="name">Upload File:</label>
              <input type="file" name="avtar" id="avtar" class="form-control" v-on:change="onFileChange"
              >
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <textarea name="description" id="description" cols="30" rows="5" class="form-control"
                        placeholder="Task Description" v-model="task.description"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" @click="createTask" class="btn btn-primary">Submit</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="update_task_model">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Update Task</h4>
          </div>
          <div class="modal-body">

            <div class="alert alert-danger" v-if="errors.length > 0">
              <ul>
                <li v-for="error in errors">{{ error }}</li>
              </ul>
            </div>

            <div class="form-group">
              <label>Name:</label>
              <input type="text" placeholder="Task Name" class="form-control"
                     v-model="update_task.name">
            </div>
            <div class="form-group">
              <label>Started Date:</label>
              <input type="date" class="form-control"
                     v-model="update_task.started_date">
            </div>

            <div class="form-group">
              <label for="name">Select Category:</label><br>
              <input type="radio" id="one" value="One" v-model="update_task.category">
              <label for="one">One</label>
              <input type="radio" id="two" value="Two" v-model="update_task.category">
              <label for="two">Two</label>
              <br>
            </div>

            <div class="form-group">
              <label for="name">Select Option:</label><br>
              <select v-model="update_task.option">
                <option disabled value="">Please select one</option>
                <option>A</option>
                <option>B</option>
                <option>C</option>
              </select>

            </div>
            <!-- <div class="form-group">
              <label for="name">Upload File:</label>
              <input type="file" name="avtar" id="avtar"  class="form-control" v-on:change="onFileChange"
              >
            </div> -->

            <div class="form-group">
              <label for="description">Description:</label>
              <textarea cols="30" rows="5" class="form-control"
                        placeholder="Task Description" v-model="update_task.description"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" @click="updateTask" class="btn btn-primary">Submit</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

  </div>
</template>

<script>
Vue.component('pagination', require('laravel-vue-pagination'));
// import DatePick from 'vue-date-pick';
// import 'vue-date-pick/dist/vueDatePick.css';
export default {
  data() {
    return {
      laravelData: {},
      // components: {DatePick},
      task: {
        name: '',
        id: '',
        description: '',
        date: '',
        file: '',
        selected: '',
        checkedNames: [],
        category: '',
      },
      errors: [],
      tasks: [],
      update_task: {}
    }
  },

  mounted() {
    // Fetch initial results
    this.getResults();
    this.readTasks();
  },

  methods: {

    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get('/task?page=' + page)
          .then(response => {
            var _this = this;
            var _laravelData = response.data.tasks;
            console.log(this.laravelData.data);
            this.laravelData = _laravelData;
            _this.tasks = _laravelData.data;


          });
    },

    initAddTask() {
      $("#add_task_model").modal("show");
      this.reset();
    },

    onFileChange(e) {
      console.log(e.target.files[0]);
      this.task.file = e.target.files[0];
    },

    createTask(e) {

      const config = {
        headers: {'content-type': 'multipart/form-data'}
      }

      let formData = new FormData();
      formData.append('name', this.task.name);
      formData.append('description', this.task.description);
      formData.append('selected', this.task.selected);
      formData.append('checkedNames', this.task.checkedNames);
      formData.append('category', this.task.category);
      formData.append('date', this.task.date);
      formData.append('file', this.task.file);

      axios.post('/task', formData, config)
          .then(response => {
            this.reset();
            this.tasks.push(response.data.task);
            $("#add_task_model").modal("hide");
          })
          .catch(error => {
            this.errors = [];
            if (error.response.data.name) {
              this.errors.push(error.response.data.name[0]);
            }
            if (error.response.data.category) {
              this.errors.push(error.response.data.category[0]);
            }
            if (error.response.data.date) {
              this.errors.push(error.response.data.date[0]);
            }
            if (error.response.data.description) {
              this.errors.push(error.response.data.description[0]);
            }
            if (error.response.data.category) {
              this.errors.push(error.response.data.category[0]);
            }
          });

    },
    reset() {
      this.task.name = '';
      this.task.description = '';
      this.task.date = '';
      this.task.selected = '';
      this.checkedNames = '';
      this.task.category = '';

    },

    readTasks() {
      axios.get('/task')
          .then(response => {
            // console.log(response.data);
            this.tasks = response.data.tasks.data;

          });
    },
    initUpdate(index) {
      console.log(this.tasks[index]);
      this.errors = [];
      $("#update_task_model").modal("show");
      this.update_task = this.tasks[index];
    },

    updateTask() {
      axios.patch('/task/' + this.update_task.id, {
        name: this.update_task.name,
        description: this.update_task.description,
        date: this.update_task.started_date,
        option: this.update_task.option,
        category: this.update_task.category,
      })
          .then(response => {

            $("#update_task_model").modal("hide");

          })
          .catch(error => {
            this.errors = [];
            console.log(error.response.data);
            if (error.response.data.name) {
              this.errors.push(error.response.data.name[0]);
            }
            if (error.response.data.category) {
              this.errors.push(error.response.data.category[0]);
            }
            if (error.response.data.date) {
              this.errors.push(error.response.data.date[0]);
            }
            if (error.response.data.description) {
              this.errors.push(error.response.data.description[0]);
            }
            if (error.response.data.category) {
              this.errors.push(error.response.data.category[0]);
            }
          });
    },

    deleteTask(index) {
      let conf = confirm("Do you ready want to delete this task?");
      if (conf === true) {

        axios.delete('/task/' + this.tasks[index].id)
            .then(response => {

              this.tasks.splice(index, 1);

            })
            .catch(error => {

            });
      }
    }
  }
}
</script>

<style scoped>
img {
  vertical-align: middle;
  height: 50px;
  width: 100px;
}
</style>