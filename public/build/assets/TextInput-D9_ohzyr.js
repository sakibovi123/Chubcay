import{j as u,r as s}from"./app-50jevO9L.js";function d({message:r,className:t="",...e}){return r?u.jsx("p",{...e,className:"text-sm text-red-600 "+t,children:r}):null}const x=s.forwardRef(function({maxLength:t="",type:e="text",className:c="",isFocused:f=!1,...i},n){const o=n||s.useRef();return s.useEffect(()=>{f&&o.current.focus()},[]),u.jsx("input",{...i,type:e,className:"border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm "+c,ref:o,maxLength:t})});export{d as I,x as T};
