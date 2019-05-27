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

        // this.test = this.test.bind(this);
    }

    componentDidMount = () => {
        axios.get('http://localhost:8000/get_data')
        .then(response => {
            this.setState({
                tasks: response.data
            })
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
                console.log(response);
            })
            .catch(error => {
                console.log(error);
            })
        } else {
            console.log("input is empty");
        }
    }

    update = (event) => {
        this.setState({
            item_input: event.target.value,
        });
    }

    render() {
        return (
            <div>
                <ul>
                    {
                        this.state.tasks.map((item, i) => (
                            <li key = {i}>
                                { item }
                                { ' ' }
                            </li>
                        ))
                    }
                </ul>
                <input 
                    type = "text" 
                    value = { this.state.item_input }
                    onChange = { this.update }
                />
                <input 
                    type = "button" 
                    value = "click" 
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
