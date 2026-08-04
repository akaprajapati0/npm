import axios from "axios";
import {
  WHATSAPP_EVENTS,
  WhatsappEventKey,
} from "../types/whatsappEvents";

export interface WhatsappImageHeader {
  link: string; // must be public HTTPS URL
}

type WhatsappVariable =
  | string
  | number
  | null
  | undefined;

type WhatsappComponent =
  | {
    type: "body";
    parameters: { type: "text"; text: string }[];
  }
  | {
    type: "button";
    sub_type: "url";
    index: string;
    parameters: { type: "text"; text: string }[];
  };

interface SendWhatsappEventOptions {
  mobile: string;
  event: WhatsappEventKey;
  variables?: WhatsappVariable[];
  buttonParams?: string[]; // NEW
  image?: {
    link: string;
  };
  overrideBot?: "yes" | "no";
}

interface WhatsappPayload {
  mobile: string;
  templateid: string;
  overridebot: "yes" | "no";
  header?: {
    type: "image";
    media: { link: string };
  };
  template?: {
    components: WhatsappComponent[];
  };
}



export const sendWhatsappEvent = async ({
  mobile,
  event,
  variables = [],
  buttonParams = [],
  image,
  overrideBot = "yes",
}: SendWhatsappEventOptions) => {
  try {
    const eventConfig = WHATSAPP_EVENTS[event];



    if (variables.length !== eventConfig.variables) {
      throw new Error(
        `WhatsApp variable mismatch for ${event}. Expected ${eventConfig.variables}, got ${variables.length}`
      );
    }


    if (
      "buttonVariables" in eventConfig &&
      buttonParams.length !== eventConfig.buttonVariables
    ) {
      throw new Error(
        `WhatsApp button variable mismatch for ${event}. Expected ${eventConfig.buttonVariables}, got ${buttonParams.length}`
      );
    }


    const payload: WhatsappPayload = {
      mobile: mobile.replace("+", ""),
      templateid: eventConfig.templateId,
      overridebot: overrideBot,
    };


    if (eventConfig.headerType === "image" && image?.link) {
      payload.header = {
        type: "image",
        media: {
          link: image.link,
        },
      };
    }


    const components: any[] = [];

    if (variables.length > 0) {
      components.push({
        type: "body",
        parameters: variables.map((value) => ({
          type: "text",
          text: String(value ?? ""),
        })),
      });
    }


    if (buttonParams.length > 0) {
      components.push({
        type: "button",
        sub_type: "url",
        index: "0",
        parameters: buttonParams.map((param) => ({
          type: "text",
          text: param,
        })),
      });
    }

    if (components.length > 0) {
      payload.template = {
        components,
      };
    }


    const test = await axios.post(
      process.env.CUNNEKT_API_URL!,
      payload,
      {
        headers: {
          "API-KEY": process.env.CUNNEKT_API_KEY!,
          "Content-Type": "application/json",
        },
        timeout: 30000,
      }
    );
    console.log(test.data)
    return {
      success: true,
    };
  } catch (error: any) {
    console.error(
      "[WhatsApp Error]",
      error.response?.data || error.message
    );

    return {
      success: false,
      error: error.response?.data || error.message,
    };
  }
};