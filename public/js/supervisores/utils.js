export const validateInputs = (startDate, endDate, campaigns, userGroups) => {
    if (!startDate || !endDate) {
        alert("Seleccione las fechas de inicio y fin.");
        return false;
    }
    if (campaigns.length === 0 || userGroups.length === 0) {
        alert("Seleccione al menos una campaña y un grupo de usuario.");
        return false;
    }
    return true;
};

export const combineData = (userTlogData, agentLogData) => {
    return userTlogData.map((userItem, index) => ({
        ...userItem,
        ...agentLogData[index]
    }));
};

export const renderTable = (data, tableBody) => {
    tableBody.innerHTML = ''; // Limpiar tabla
    data.forEach(row => {
        const tr = document.createElement("tr");
        Object.values(row).forEach(value => {
            const td = document.createElement("td");
            td.textContent = value || 'N/A';
            tr.appendChild(td);
        });
        tableBody.appendChild(tr);
    });
};
