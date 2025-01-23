import { fetchCampaigns, fetchUserGroups, fetchLogs } from './api.js';
import { validateInputs, combineData, renderTable } from './utils.js';

document.addEventListener("DOMContentLoaded", () => {
    const campaignsSelect = document.getElementById("campaigns");
    const groupsSelect = document.getElementById("gruposUsuario");
    const enviarBtn = document.getElementById("enviarBtn");
    const tableBody = document.querySelector("#resultados-table tbody");

    // Cargar campañas y grupos
    fetchCampaigns(campaignsSelect);
    fetchUserGroups(groupsSelect);

    // Enviar datos
    enviarBtn.addEventListener("click", async () => {
        const fechaInicio = document.getElementById("fechaInicio").value;
        const fechaFin = document.getElementById("fechaFin").value;
        const campaigns = Array.from(campaignsSelect.selectedOptions).map(opt => opt.value);
        const userGroups = Array.from(groupsSelect.selectedOptions).map(opt => opt.value);

        if (!validateInputs(fechaInicio, fechaFin, campaigns, userGroups)) return;

        try {
            const logs = await fetchLogs(fechaInicio, fechaFin, campaigns, userGroups);
            const combinedData = combineData(logs.userTlogData, logs.agentLogData);

            renderTable(combinedData, tableBody);
            document.getElementById("resultados-section").style.display = "block";
        } catch (error) {
            console.error("Error al cargar los datos:", error);
            alert("Ocurrió un error al cargar los datos.");
        }
    });
});
