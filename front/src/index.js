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
            data: null,
        }

        // this.test = this.test.bind(this);
    }

    test = () => {
        axios.get('http://localhost:8000/test')
        .then(response => {
            this.setState({
                data: response.data
            });
        })
        .catch(error => {
            console.log(error);
        });
    }

    render() {
        return (
            <div>
                <h1>{ this.state.data }</h1>
                {/* <h1>{ this.state.name }</h1> */}
                <button onClick = { this.test }>click</button>
            </div>
        );
    }

}

ReactDOM.render(<Test />, document.getElementById('root'));

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
