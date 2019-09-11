import React, {Component} from 'react'
import axios from 'axios'
import SearchResult from './search_result';

class Filter extends Component{

    constructor(props){

        super(props);
        this.state = {

            customers:[],
            products:[],
            searchData:[],
            'selectedCustomer':'',
            'selectedProduct':'',
            'fromDate':'',
            'toDate':'',
            'loaded':true,
        }


        this.handleChange= this.handleChange.bind(this);
        this.handleSubmit= this.handleSubmit.bind(this);
    }

    handleChange(e){

        this.setState({


            [e.target.id]:e.target.value

        })
    }

    handleSubmit(e){

        this.setState({

            loaded:false
        })
        let url = location.origin;

        e.preventDefault()

        let query = url+'/product-profit-loss/search?product='+this.state.selectedProduct+'&from_date='+this.state.fromDate+'&to_date='+this.state.toDate
        axios.get(query)
        .then( (res) => {

            // window.history.pushState(url, '', query)
            this.setState({

                loaded:true
            })
            this.setState({searchData:res.data})
        })
        .catch( (res) => {

            this.setState({

                loaded:true
            })

        })


    }

    componentDidMount(){

        let url = location.origin;

            //get all products head

         axios.get(url+'/all-products')
         .then( (res) => {

             this.setState({ products:res.data })
         })
    }
    render(){

        return(

       <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                <h3 class="col-sm-10 box-title m-b-0"><b>Product Profit Loss Filter</b></h3>

                    <div class="row">
                        <form  onSubmit={this.handleSubmit}>
                    <div class="form-group col-lg-4">
                            <label>Products</label>
                            <select class="form-control" value={this.state.selectedProduct} onChange={this.handleChange} name="customer" id="selectedProduct">
                                <option value="">Please select product</option>
                                {this.state.products.map(product =>
                            <option value={product.id}>{product.code}-{product.title}</option>
                            )};
                            </select>
                    </div>
                    <div class="form-group col-lg-4">
                            <label>From Date</label>
                            <input type="date" id="fromDate" onChange={this.handleChange} name="from_date" class="form-control" placeholder="mm/dd/yyyy"/>
                    </div>
                    <div class="form-group col-lg-4">
                            <label>To Date</label>
                            <input type="date" id="toDate" onChange={this.handleChange}  name="to_date" class="form-control" placeholder="mm/dd/yyyy"/>
                    </div>

                    <div class="form-group col-lg-4">
                            <label></label>
                            <input type="submit" class="btn btn-primary" value="search"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <SearchResult  results={this.state.searchData} loaded={this.state.loaded}/>
    </div>

        );
    }
}

export default Filter
