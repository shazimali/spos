import React, {Component} from 'react'
import axios from 'axios'
import SearchResult from './search_result';
class Filter extends Component{

    constructor(props){

        super(props);
        this.state = {

            suppliers:[],
            searchData:'',
            selectedSupplier:'',
            fromDate:'',
            toDate:'',
            loaded:true,
            totalPurcahse:0,
            totalPay:0,
            balance:0,
            print:false
        }


        this.handleChange= this.handleChange.bind(this);
        this.handleSubmit= this.handleSubmit.bind(this);
        this.handlePrint= this.handlePrint.bind(this);

    }

    handleChange(e){

        this.setState({


            [e.target.id]:e.target.value

        })
    }

    handleSubmit(e){

        e.preventDefault()
        if(this.state.selectedSupplier != ""){

            this.setState({

                loaded:false,
                print:true,
                searchData:''
            })
            let url = location.origin;

            e.preventDefault()

            let query = url+'/supplier-ledger/search?supplier='+this.state.selectedSupplier+'&from_date='+this.state.fromDate+'&to_date='+this.state.toDate
            axios.get(query)
            .then( (res) => {


                this.setState({
                    loaded:true,
                    searchData:res.data.final_collection,
                    balance: res.data.balance
                })
            })
            .catch( (res) => {

                this.setState({

                    loaded:true
                })

            })
        }

        else{

            this.setState({

                print:false
            })

            alert("Please select customer.")
        }



    }

    handlePrint(e){

        if(this.state.selectedSupplier != ""){

            let url = location.origin;

            e.preventDefault()

            let query = url+'/supplier-ledger/show?supplier='+this.state.selectedSupplier+'&from_date='+this.state.fromDate+'&to_date='+this.state.toDate
            window.open(query,'_blank' ,  'fullscreen=yes')
            location.reload();
        }

        else{

            this.setState({

                print:false
            })

          alert("Please select customer.")
        }

    }

    componentDidMount(){

        let url = location.origin;

            //get all suppliers

        axios.get(url+'/all-suppliers')
        .then( (res) => {

            this.setState({suppliers:res.data})
        })
    }
    render(){

        return(

       <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="col-sm-10 box-title m-b-0"><b>Supplier Ledger Filter</b>
                    {
                        this.state.print ?
                    <button  onClick={this.handlePrint} class="btn pull-right btn-primary">Print</button>
                    : ''
                    }
                    </h3>
                    <br/>

                    <div class="row">
                        <form  onSubmit={this.handleSubmit}>
                        <div class="form-group col-lg-4">
                        <label>Supplier</label>
                        <select class="form-control" value={this.state.selectedSupplier} onChange={this.handleChange} name="supplier" id="selectedSupplier">
                            <option value="">All Supplier</option>
                            {this.state.suppliers.map(supplier =>
                            <option  value={supplier.id}>{supplier.name}</option>
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

                    <div class="form-group col-lg-2">
                            <label></label>
                            <input type="submit" class="btn btn-primary" value="search"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <SearchResult balance={this.state.balance}  results={this.state.searchData} totalPay= {this.state.totalPay} loaded={this.state.loaded} totalPurchase={this.state.totalPurchase} />
    </div>

        );
    }
}

export default Filter
