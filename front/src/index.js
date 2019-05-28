import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
// import App from './App';
import * as serviceWorker from './serviceWorker';
import axios from 'axios';

class Test extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            tasks: [],
            item_input: ''
        }
    }

    // Onload function (GET all tasks)
    componentDidMount = () => {
        axios.get('http://localhost:8000/get_data')
        .then(response => {
            this.setState({
                tasks: response.data,
            });
        })
        .catch(error => {
            console.log(error);
        })
    }

    add = () => {
        if(this.state.item_input !== '') {
            let task = JSON.stringify({
                name: this.state.item_input,
            })

            axios.post('http://localhost:8000/add', task, {
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                // Wrap new item in order to render it
                let new_item = { id: response.data, name: this.state.item_input };

                this.setState(prev => {
                    return{
                        item_input: '',
                        tasks: prev.tasks.concat(new_item),
                    };
                });
            })
            .catch(error => {
                console.log(error);
            })
        } else {
            console.log("input is empty");
        }
    }

    remove = (id, key) => {
        let data = JSON.stringify({
            id: id,
        })

        axios.delete('http://localhost:8000/delete_task', { data: data }, {
            headers: {
                'Content-Type': 'application/json',
            }
        })
        .then(response => {
            console.log(response);
            this.setState(prev => {
                let tasks = [...prev.tasks]

                tasks.splice(key, 1);

                return {
                    item_input: '',
                    tasks
                };
            });
        })
        .catch(error => {
            console.log(error);
        })
    }

    update = (event) => {
        this.setState({
            item_input: event.target.value,
        });
    }

    render() {
        return (
            <div>
                {/* List of tasks */}
                <ul>
                    {
                        this.state.tasks.map((item, i) => (
                            <li key = {i}>
                                { item.name }
                                { ' ' }
                                <input
                                    type = "button"
                                    value = "delete"
                                    onClick = { () => this.remove(item.id, i) }
                                />
                            </li>
                        ))
                    }
                </ul>
                {/* Task creation form */}
                <input 
                    type = "text" 
                    value = { this.state.item_input }
                    onChange = { this.update }
                />
                <input 
                    type = "button" 
                    value = "add item" 
                    onClick = { this.add } 
                />
            </div>
        );
    }
}

ReactDOM.render(<Test />, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
