class Table extends React.Component {
    constructor(props) {
        super(props);
            this.state = {data: [],
            perPage: 10,
            showPage:1,
            pagesList:[],
            sortingKey:"id",
            filterKey: "id",
            filteredData: []};
            this.handleClick = this.handleClick.bind(this);
        }

    getPerPage() {
        document.getElementById("showPerPage").onchange = function () {
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
        var strings = ["name", "surname", "address"];
        return data.sort( function(a, b) {
            var x = a[this.state.sortingKey];
            var y = b[this.state.sortingKey];
            if (strings.indexOf(this.state.sortingKey) > -1 && strings.indexOf(this.state.sortingKey) > -1) {
                return x.localeCompare(y, "lt")
            }
            if (this.state.sortingKey == "date") {
                if (x < y) return 1;
                if (x > y) return -1;
            }
            if (x > y) return 1;
            if (x < y) return -1;
            return 0;
        }.bind(this));
    }

    //Paspaudus "Ieškoti" ieško atitinkamų įrašų.
    //"Enter" klavišo paspaudimas atitinka mygtuko "Ieškoti" paspaudimą.
    getFilteredData() {
        var filterText = "";

        document.getElementById("resetFiltering").onclick = function() {
            this.setState({filteredData:this.sortData(this.state.data), showPage:1});
            document.getElementById("filter").value=null;
            this.getPagesArray();
            filterText = "";
        }.bind(this);

        document.getElementById("toggleFiltering").onclick = function () {
            filterText = document.getElementById("filter").value.toUpperCase();
            var filtered = this.sortData(this.state.data).filter(function (n) {
                return n[this.state.filterKey].toString().toUpperCase().indexOf(filterText) > -1;
            }.bind(this));
            this.setState({filteredData: filtered, showPage:1});
            this.getPagesArray();
        }.bind(this);

        document.getElementById("filter").onkeyup = function () {
            if (event.keyCode === 13) {
                document.getElementById("toggleFiltering").click()
            }
        }
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
        this.getPerPage();
        this.getSortingKey();
        this.getFilterKey();
        this.getFilteredData();
    }

    renderPagination() {
        return (
            <ul className="pagination pagination-sm">
                {this.state.pagesList.map((page) => {
                return(
                    <li key={page} className={this.state.showPage == page ? "active page-item" : "page-item"}>
                        <a href="#" id={page} onClick={this.handleClick} className={"page-link"}>{page}</a>
                    </li>
                    );})}
            </ul>
        );
    }

    renderTable() {
        return (
            <table className="table table-responsive table-striped vertical-align order-info">
                <thead className="text-center">
                    <tr>
                        <th className="align-middle">Užsakymo nr.</th>
                        <th className="align-middle">Užsakovo vardas</th>
                        <th className="align-middle">Užsakovo pavardė</th>
                        <th className="align-middle">Užsakymo data</th>
                        <th className="align-middle">Kiekis</th>
                        <th className="align-middle">Suma, €</th>
                    </tr>
                </thead>
                <tbody>
                {this.getPageData().map((data) => {
                    return(
                        <tr>
                            <td className="align-middle"><a href={"/orders/info/"+data['id'].toString()}>{data['id']}</a></td>
                            <td className="align-middle">{data['name']}</td>
                            <td className="align-middle">{data['surname']}</td>
                            <td className="align-middle">{data['date']}</td>
                            <td className="text-center align-middle">{data['quantity']}</td>
                            <td className="text-right align-middle">{data['total'].toFixed(2)}</td>
                    </tr>
                    );
                })}
                </tbody>
            </table>
        )
    }

    render() {
        return (
            <div>
                <div className="row">
                    {this.renderPagination()}
                </div>
                <div>
                    {this.renderTable()}
                </div>
            </div>
        );
    }
}

window.Table = Table;
