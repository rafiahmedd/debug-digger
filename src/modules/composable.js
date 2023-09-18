import {useRestApi} from "./rest";

// This is a composable function that can be used in any component
// to access the app variables and the REST API methods (get, post, put, patch, del)
// and the translate function
export function composable(){
    const appVars = window.debugDiggerAdmin;
    const { get, post, put} = useRestApi();
    
    return {
        get, post, put, appVars
    }
}