const uploadContainer = document.getElementById('upload-container');
const fileInput = document.getElementById('file-input');
const csvTable = document.getElementById('csv-table');
const regionFilter = document.getElementById('region-filter');
const sizeFilter = document.getElementById('size-filter');
let csvDataArray = [];

uploadContainer.addEventListener('click', () => fileInput.click());

uploadContainer.addEventListener('dragover', (event) => {
    event.preventDefault();
    event.stopPropagation();
    uploadContainer.style.backgroundColor = '#f0f0f0';
});

uploadContainer.addEventListener('dragleave', (event) => {
    event.preventDefault();
    event.stopPropagation();
    uploadContainer.style.backgroundColor = '#fff';
});

uploadContainer.addEventListener('drop', (event) => {
    event.preventDefault();
    event.stopPropagation();
    uploadContainer.style.backgroundColor = '#fff';
    fileInput.files = event.dataTransfer.files;
    handleFileUpload();
});

fileInput.addEventListener('change', handleFileUpload);

function handleFileUpload() {
    const file = fileInput.files[0];
    if (file && file.type === 'text/csv') {
        const reader = new FileReader();
        reader.onload = function(event) {
            const csvData = event.target.result;
            csvDataArray = csvToArray(csvData);
            populateFilters(csvDataArray);
            displayTable(csvDataArray);
        };
        reader.readAsText(file);
    } else {
        alert('Please upload a valid CSV file.');
    }
}

function csvToArray(str, delimiter = ",") {
    const headers = str.slice(0, str.indexOf("\n")).trim().split(delimiter);
    const rows = str.slice(str.indexOf("\n") + 1).trim().split("\n");

    return rows.map(row => {
        const values = row.split(delimiter);
        return headers.reduce((object, header, index) => {
            object[header.trim()] = values[index].trim();
            return object;
        }, {});
    });
}

function populateFilters(data) {
    const regions = new Set();
    const sizes = new Set();

    data.forEach(row => {
        regions.add(row.Region);
        sizes.add(row.Size);
    });

    updateFilterOptions(regionFilter, regions);
    updateFilterOptions(sizeFilter, sizes);
}

function updateFilterOptions(filterElement, options) {
    filterElement.innerHTML = '<option value="">All</option>';
    options.forEach(option => {
        const optionElement = document.createElement('option');
        optionElement.value = option;
        optionElement.textContent = option;
        filterElement.appendChild(optionElement);
    });
}

function displayTable(data) {
    let html = '<table><thead><tr><th>Region</th><th>Size</th><th>Price</th></tr></thead><tbody>';
    data.forEach(row => {
        html += `<tr><td>${row.Region}</td><td>${row.Size}</td><td>${row.Price}</td></tr>`;
    });
    html += '</tbody></table>';
    csvTable.innerHTML = html;
}
