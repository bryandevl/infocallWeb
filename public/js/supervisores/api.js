const API_BASE_URL = 'http://192.168.21.12:5000';

const fetchData = async (url, options = {}) => {
    const response = await fetch(url, options);
    if (!response.ok) throw new Error(`Error en la solicitud: ${response.statusText}`);
    return response.json();
};

export const fetchCampaigns = async (selectElement) => {
    try {
        const data = await fetchData(`${API_BASE_URL}/test/campid`);
        data.forEach(({ campaign_id }) => {
            const option = document.createElement("option");
            option.value = campaign_id;
            option.textContent = campaign_id;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar campañas:", error);
    }
};

export const fetchUserGroups = async (selectElement) => {
    try {
        const data = await fetchData(`${API_BASE_URL}/cliente/UserGroup`);
        data.forEach(({ user_group }) => {
            const option = document.createElement("option");
            option.value = user_group;
            option.textContent = user_group;
            selectElement.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar grupos de usuario:", error);
    }
};

export const fetchLogs = async (startDate, endDate, campaignIds, grupouser) => {
    const payload = { startDate: `${startDate} 00:00:00`, endDate: `${endDate} 23:59:59`, campaignIds, grupouser };

    const userTlogPromise = fetchData(`${API_BASE_URL}/test/usertlog`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
    });

    const agentLogPromise = fetchData(`${API_BASE_URL}/test/agentlog`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
    });

    const [userTlogData, agentLogData] = await Promise.all([userTlogPromise, agentLogPromise]);
    return { userTlogData, agentLogData };
};
