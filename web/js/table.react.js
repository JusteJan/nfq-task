class BigTable extends React.Component {
    constructor(props) {
        super(props);
            this.state = {data: [],
            perPage: 10,
            showPage:1,
            pagesList:[],
            sortingKey:'id',
            filterKey: 'id',
            filteredData: []};
            this.handleClick = this.handleClick.bind(this);
        }

    getPerPage() {
        document.getElementById("showPerPage").oninput = function () {
            this.setState({perPage: document.getElementById("showPerPage").value, showPage:1});
            this.getPagesArray();
        }.bind(this);
    }

    getSortingKey() {
        document.getElementById("chooseSorting").oninput = function () {
            this.setState({sortingKey: document.getElementById("chooseSorting").value})
            this.setState({filteredData: this.sortData(this.state.filteredData)});
        }.bind(this);
    }

    getFilterKey() {
        document.getElementById("chooseFiltering").oninput = function () {
            this.setState({filterKey: document.getElementById("chooseFiltering").value})
        }.bind(this);
    }

    sortData(data) {
        var strings = ['name', 'surname', 'address'];
        return data.sort( function(a, b) {
            var x = a[this.state.sortingKey];
            var y = b[this.state.sortingKey];
            if (strings.indexOf(this.state.sortingKey) > -1 && strings.indexOf(this.state.sortingKey) > -1) {
                return x.localeCompare(y, 'lt')
            }
            if (this.state.sortingKey == 'date') {
                if (x < y) return 1;
                if (x > y) return -1;
            }
            if (x > y) return 1;
            if (x < y) return -1;
            return 0;
        }.bind(this));
    }

    getFilteredData() {
        var filterText = "";
        document.getElementById("resetFiltering").onclick = function() {
            this.setState({filteredData:this.sortData(this.state.data), showPage:1});
            this.getPagesArray();
            filterText = "";
        }.bind(this);
        document.getElementById("toggleFiltering").onclick = function () {
            filterText = document.getElementById("filter").value;
            var filtered = this.sortData(this.state.data).filter(function (n) {
                console.log(n[this.state.filterKey].toString().includes(filterText));
                return n[this.state.filterKey].toString().indexOf(filterText) > -1;
            }.bind(this));
            this.setState({filteredData: filtered, showPage:1});
            this.getPagesArray();
        }.bind(this);
    }

    getPageData() {
        console.log(this.getFilteredData());
        return this.state.filteredData.filter( function (n, ind) {
            return ind >= this.state.perPage*(this.state.showPage-1) && ind < this.state.perPage*this.state.showPage;
        }.bind(this));
    }

    handleClick(event) {
        this.setState({showPage: Number(event.target.id)});
    }


    getPagesArray() {
        var pageList = [];
        for (let i = 1; i <= Math.ceil(this.state.filteredData.length/this.state.perPage); i++) {
            pageList.push(i);
        };
        this.setState({pagesList:pageList});
    }

    componentDidMount() {
        axios.get(this.props.url)
            .then(function (response) {
                console.log(response.data)
                this.setState({data: response.data, filteredData:response.data});
                this.getPagesArray();
            }.bind(this));
        this.getSortingKey();
        this.getFilterKey();
        this.getFilteredData();
        this.getPerPage();
    }

    renderPagination() {
        return (
            <ul className="pagination">
                {this.state.pagesList.map((page) => {
                return(
                    <li key={page}><a href="#" id={page} onClick={this.handleClick}>{page}</a>

                    </li>
                    );})}
            </ul>
        );
    }

    renderTable() {
        return (
            <table className="table table-bordered table-responsive table-striped">
                <tr>
                    <th>Užsakymo numeris</th>
                    <th>Užsakovo vardas</th>
                    <th>Užsakovo pavardė</th>
                    <th>Užsakymo data</th>
                    <th>Kiekis</th>
                    <th>Galutinė kaina</th>
                </tr>
                {this.getPageData().map((data) => {
                    return(
                        <tr>
                            <td><a href={"/order/info/"+data['id'].toString()}>{data['id']}</a></td>
                            <td>{data['name']}</td>
                            <td>{data['surname']}</td>
                            <td>{data['date']}</td>
                            <td>{data['quantity']}</td>
                            <td>{data['total']}</td>
                    </tr>
                    );
                })}
            </table>
        )
    }




render() {
    return (
        <div>
        <div>
            {this.renderPagination()}
        </div>
        <div>
            {this.renderTable()}
        </div>
        </div>
    );
}

}

window.BigTable = BigTable;

//ReactDOM.render(
//<BigTable url={}/>,
//    document.querySelector("#app")
//);