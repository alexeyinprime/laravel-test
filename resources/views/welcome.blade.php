@verbatim
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список пользователей</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/theme.css" /> -->
    <style>
        body {
            --bs-body-bg: #000;
            --bs-body-color: #fff;
            --input-bg: #000
        }
        #app {
            opacity: 1;
            transition: opacity .25s
        }
        #app[v-cloak] {
            opacity: 0;
            /* display: none */
        }
        [data-idx]::before {
            content: attr(data-idx)".\00a0"
        }
    </style>
</head>
<body>

<div class="container" id="app" v-cloak>

    <h1 class="text-center" v-once>{{ titleText }}</h1>
    <hr/>

    <div class="row">

        <div class="col-12 col-sm-6">
            <div class="card text-bg-dark">
                <div class="card-header">
                    <h2 class="card-title"
                        v-text="subtitleFormText"
                    ></h2>
                </div>

                <div class="card-body">
                    <form class="form">
                        <label id="inputUsernameHelp" for="validateUsername" class="form-label"
                               v-text="placeholderText"
                        ></label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control text-light" aria-describedby="inputUsernameHelp" id="validateUsername"
                                   v-model="inputValue"
                                   :class="{'is-invalid': invalidName}"
                                   :placeholder="placeholderText"
                                   @keypress.enter="addUser"
                            />
                            <div id="validateUsernameFeedback" class="invalid-feedback">
                                Неверное имя пользователя
                            </div>
                        </div>
                        <hr/>
                        <label id="selectSkillsHelp" for="selectSkills" class="form-label"
                               v-text="selectLabelText"
                        ></label>
                        <div class="input-group">
                            <select class="form-select form-select-sm" id="selectSkills" multiple aria-describedby="selectSkillsHelp"
                                    v-model="selectedSkills"
                            >
                                <option value="php">php</option>
                                <option value="js">js</option>
                                <option value="go">go</option>
                                <option value="java">java</option>
                            </select>
                        </div>
                        <hr/>
                        <button class="btn btn-success rounded-pill" type="submit"
                                :disabled="invalidName"
                                @click.prevent="addUser"
                        >Добавить</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">{{ subtitleListText }} ({{ users.length }})</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group" v-if="users.length">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap"
                            v-for="(user, idx) in users"
                            :data-idx="idx + 1"
                            :key="idx"
                        >
                            <span class="me-auto">{{ user.name }}</span>
                            <span class="badge text-bg-success rounded-pill me-3"
                                  v-for="skill in user.description"
                            >
                  {{ skill }}
                </span>
                            <!-- <input type="text" @click.stop> -->
                            <button class="btn btn-sm btn-danger rounded-pill end-0"
                                    @click="removeUser(idx)"
                            >Удалить</button>
                        </li>
                    </ul>
                    <h3 v-else>нет пользователей</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script>
    Vue.createApp({
        data: () => ({
            counter: 0,
            titleText: 'Пользователи',
            subtitleFormText: 'Новый пользователь',
            subtitleListText: 'Список пользователей',
            placeholderText: 'Имя',
            selectLabelText: 'Навыки',
            inputValue: '',
            selectedSkills: [],
            invalidName: false,
            users: [
                // {
                //   name: 'user_name',
                //   skills: ['php', 'js', 'go', 'java']
                // }
            ]
        }),
        mounted() {
            fetch('/users')
                .then(response => response.json())
                .then(json => {
                    this.users = json
                })
        },
        methods: {
            toCapitalize(text) {
                return text.charAt(0).toUpperCase() + text.slice(1)
            },
            addUser() {
                if (this.inputValue.trim() != '') {
                    const u = {
                        name: this.toCapitalize(this.inputValue),
                        description: this.selectedSkills
                    }
                    this.users.push(u)
                    fetch('https://jsonplaceholder.typicode.com/users', {
                        method: 'POST',
                        body: JSON.stringify(u),
                        headers: {
                            'Content-type': 'application/json; charset=UTF-8'
                        }
                    })
                        .then((response) => response.json())
                        .then((json) => console.log(json))

                    this.selectedSkills = []
                    this.inputValue = ''
                }
            },
            removeUser(idx) {
                this.users.splice(idx, 1)
                fetch('https://jsonplaceholder.typicode.com/users/'+idx, {
                    method: 'DELETE',
                }).then(response => console.log(response.ok))
            }
        },
        watch: {
            inputValue(val) {
                if (val.trim().length) this.invalidName = !val.match(/(^[A-Z-a-z]+$)|(^\d{1,12}$)/ugi)
            }
        },
    }).mount('#app')

</script>
</body>
</html>

@endverbatim
