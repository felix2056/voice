import Vue from 'vue';
import axios from 'axios';


const state = {
	siteSettings: {}
};

const mutations = {
	SET_SITE: (state, payload) => (state.siteSettings = payload)
};

const getters = {
	getSettingsByIndex: state => index => state.siteSettings[index]
};

const actions = {
	async fetchSiteData({ commit }) {
		return new Promise((resolve, reject) => {
			let url = `/settings`;

			axios.get(url)
			.then((response) => {
				commit('SET_SITE', response.data.settings)
				resolve(response);
			})
			.catch(err => {
				reject(err)
				console.log(err)
			});
		})
	}
};

export default {
	state,
	mutations,
	getters,
	actions
}